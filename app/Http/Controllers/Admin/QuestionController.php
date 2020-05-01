<?php

namespace App\Http\Controllers\Admin;

use App\Rating;
use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Question;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\Q;

class QuestionController extends Controller
{
    // ---- QUESTIONS ----
    public function index(Request $request)
    {
        $tests = Test::query()
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $questions = $this->getFilteredQuestions('all');

        return view('admin.question.list', [
            'tests' => $tests,
            'questions' => $questions,
            'title' => 'Všetky otázky',
            'inputs' => $request->all(),
            'from' => 'question.index',
        ]);
    }

    private function getFilteredQuestions($q = 'all')
    {
        $filter = Session::get('questionFilter');
        $category = !empty($filter['category']) ? $filter['category'] : null;
        $type = !empty($filter['type']) ? $filter['type'] : null;
        $diffFrom = !empty($filter['difficulty_from']) ? $filter['difficulty_from'] : null;
        $diffTo = !empty($filter['difficulty_to']) ? $filter['difficulty_to'] : null;
        $order = !empty($filter['order']) ? $filter['order'] : null;

        $query = Question::query()->with('categories', 'comments', 'tests');


        switch ($q) {
            case 'my':
                $query->where('created_by', Auth::user()->id);
                break;
            case 'other':
                $query->where('created_by', '!=', Auth::user()->id);
                break;
            case 'all':
            default:
                $query->where('public', true);
        }

        if ($type) {
            if ($type == 'just-interactive') $query->where('type', '=', 5);
            if ($type == 'no-interactive') $query->where('type', '<', 5);
        }
        if ($diffFrom && $diffTo) {
            $query->whereBetween('difficulty', [$diffFrom, $diffTo]);
        }

        if ($order) {
            if ($order == 1) {
                $query->orderBy('title', 'asc');
            }
            if ($order == 2) {
                $query->withCount(['comments as commentCount' => function ($query) {
                    $query->select(DB::raw('coalesce(count(*),0)'));
                }]);
                $query->orderBy('commentCount', 'desc')
                    ->orderBy('title', 'asc');
            }
            if ($order == 3) {
                $query->withCount(['ratings as ratingAvg' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }]);
                $query->orderBy('ratingAvg', 'desc')
                    ->orderBy('title', 'asc');
            }
            if ($order == 4) {
                $query->withCount(['ratings as ratingCount' => function ($query) {
                    $query->select(DB::raw('coalesce(count(*),0)'));
                }]);
                $query->orderBy('ratingCount', 'desc')
                    ->orderBy('title', 'asc');
            }
            if ($order == 5) {
                $query->withCount(['tests as popularity' => function ($query) {
                    $query->select(DB::raw('coalesce(count(*),0)'));
                }]);
                $query->orderBy('popularity', 'desc')
                    ->orderBy('title', 'asc');
            }
        } else {
            $query->orderBy('title', 'asc');
        }

        if ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->whereIn('id', $category);
            });
        }

        $questions = $query->paginate(25);

        return $questions;
    }

    public function addQuestionsToTest(Request $request)
    {
        $this->validate($request, [
            'questions' => 'required',
            'test-select' => 'required'
        ]);

        foreach ($request->input('questions') as $q) {
            $exists = DB::table('question_test')
                ->where([
                    ['question_id', $q],
                    ['test_id', $request->input('test-select')]])
                ->exists();

            if (! $exists) {
                DB::table('question_test')->insert([
                    'question_id' => $q,
                    'test_id' => $request->input('test-select')
                ]);
            }
        }

        return redirect()->route($request->input('from', 'question.index'));
    }

    public function myQuestions(Request $request)
    {
        $tests = Test::query()
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $questions = $this->getFilteredQuestions('my');

        return view('admin.question.list', [
            'tests' => $tests,
            'questions' => $questions,
            'title' => 'Moje otázky',
            'inputs' => $request->all(),
            'from' => 'question.index.my'
        ]);
    }

    public function otherQuestions(Request $request)
    {
        $tests = Test::query()
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $questions = $this->getFilteredQuestions('other');

        return view('admin.question.list', [
            'tests' => $tests,
            'questions' => $questions,
            'title' => 'Otázky od iných',
            'inputs' => $request->all(),
            'from' => 'question.index.other',
        ]);
    }

    public function show(Question $question)
    {
        $question->load('comments', 'categories', 'ratings');

        $tests = Test::query()
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $myRating = Rating::query()
            ->where('question_id', $question->id)
            ->where('user_id', Auth::id())
            ->first();

        $avgTime = null;

        if (Auth::user()->is_admin) {
            $avgTime = DB::table('measurements')
                ->select('time_spent')
                ->where('question_id', $question->id)
                ->avg('time_spent');
        }


        return view('admin.question.show', [
            'question' => $question,
            'tests' => $tests,
            'myRating' => $myRating,
            'avgTime' => $avgTime
        ]);
    }

    public function addToTest(Request $request, Question $question)
    {
        $this->validate($request, [
            'test' => 'required'
        ]);

        $count = DB::table('question_test')
            ->where([
                ['question_id', $question->id],
                ['test_id', $request->input('test')],
            ])
            ->count();

        if ($count == 0) {
            DB::table('question_test')
                ->insert([
                    'question_id' => $question->id,
                    'test_id' => $request->input('test')
                ]);
        }

        return redirect()->route('question.show', $question->id);
    }

    public function comment(Request $request, Question $question)
    {
        $this->validate($request, [
            'comment' => 'required|string'
        ]);

        $comment = new Comment([
            'user_id' => Auth::user()->id,
            'question_id' => $question->id,
            'comment' => $request->input('comment')
        ]);

        $comment->save();

        return redirect()->route('question.show', $question);
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('question.index');
    }

    public function edit(Question $question)
    {
        $question->load('categories');

        $categories = array();
        foreach ($question->categories as $c) {
            $categories[] = $c->id;
        }

        return view('admin.question.edit', ['question' => $question, 'categories' => $categories]);
    }

    public function update(Request $request, Question $question)
    {
        $this->validate($request, [
            'title' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'difficulty' => 'required',

        ]);

        $question->title = $request->input('title');
        $question->question = $request->input('question');

        $question->answer = $request->input('answer');
        $question->difficulty = $request->input('difficulty');
        $question->description = $request->input('description') ? $request->input('description') : ' ';
        $question->description_teacher = $request->input('description_teacher') ? $request->input('description_teacher') : ' ';
        $question->public = $request->input('public') != null ? true : false;

        if ($question->type <= 3) {
            $this->validate($request, [
                'answer-a' => 'required',
                'answer-b' => 'required',
                'answer-c' => 'required',
                'answer-d' => 'required',
            ]);

            $question->a = $request->input('answer-a');
            $question->b = $request->input('answer-b');
            $question->c = $request->input('answer-c');
            $question->d = $request->input('answer-d');
        } else if ($question->type == 4) {
            if ($request->file('answer-a-img') != null) {
                Storage::disk('public_uploads')->delete(ltrim($question->a, '/'));
                $path = $request->file('answer-a-img')->storeAs('img/answers', $question->id . 'a' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
                $question->a = '/' . $path;
            }
            if ($request->file('answer-b-img') != null) {
                Storage::disk('public_uploads')->delete(ltrim($question->b, '/'));
                $path = $request->file('answer-b-img')->storeAs('img/answers', $question->id . 'b' . '.' . $request->file('answer-b-img')->getClientOriginalExtension(), 'public_uploads');
                $question->b = '/' . $path;
            }
            if ($request->file('answer-c-img') != null) {
                Storage::disk('public_uploads')->delete(ltrim($question->c, '/'));
                $path = $request->file('answer-c-img')->storeAs('img/answers', $question->id . 'c' . '.' . $request->file('answer-c-img')->getClientOriginalExtension(), 'public_uploads');
                $question->c = '/' . $path;
            }
            if ($request->file('answer-d-img') != null) {
                Storage::disk('public_uploads')->delete(ltrim($question->d, '/'));
                $path = $request->file('answer-d-img')->storeAs('img/answers', $question->id . 'd' . '.' . $request->file('answer-d-img')->getClientOriginalExtension(), 'public_uploads');
                $question->d = '/' . $path;
            }
        }

        $question->save();

        $question->categories()->sync($request->input('category', []));

        return redirect()->route('question.show', $question);
    }

    public function rating(Request $request, Question $question)
    {
        $this->validate($request, [
            'value' => 'required|min:1|max:5'
        ]);

        Rating::query()->updateOrCreate([
            'question_id' => $question->id,
            'user_id' => Auth::user()->id,
        ], [
            'rating' => $request->input('value')
        ]);

        return redirect()->route('question.show', $question);
    }

    public function create()
    {
        return view('admin.question.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'type' => 'required',
            'difficulty' => 'required',
        ]);

        $type = intval($request->input('type'));

        $question = new Question([
            'title' => $request->input('title'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'type' => $type,
            'difficulty' => $request->input('difficulty'),
            'description' => $request->input('description') ? $request->input('description') : '',
            'description_teacher' => $request->input('description_teacher') ? $request->input('description_teacher') : '',
            'public' => $request->input('public') != null ? true : false,
            'created_by' => Auth::user()->id,
        ]);

        if ($type >= 1 && $type <= 3) {
            // if type is text: in rows, in cols, 2x2
            $this->validate($request, [
                'answer-a' => 'required',
                'answer-b' => 'required',
                'answer-c' => 'required',
                'answer-d' => 'required',
            ]);

            $question->fill([
                'a' => $request->input('answer-a'),
                'b' => $request->input('answer-b'),
                'c' => $request->input('answer-c'),
                'd' => $request->input('answer-d'),
            ]);

            $question->save();
        } else if ($type == 4) {
            // if type is img
            $this->validate($request, [
                'answer-a-img' => 'required',
                'answer-b-img' => 'required',
                'answer-c-img' => 'required',
                'answer-d-img' => 'required',
            ]);

            $question->fill([
                'a' => 'a',
                'b' => 'a',
                'c' => 'a',
                'd' => 'a',
            ]);

            $question->save();

            $path1 = $request->file('answer-a-img')->storeAs('img/answers', $question->id . 'a' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
            $path2 = $request->file('answer-b-img')->storeAs('img/answers', $question->id . 'b' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
            $path3 = $request->file('answer-c-img')->storeAs('img/answers', $question->id . 'c' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
            $path4 = $request->file('answer-d-img')->storeAs('img/answers', $question->id . 'd' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');

            $question->a = '/' . $path1;
            $question->b = '/' . $path2;
            $question->c = '/' . $path3;
            $question->d = '/' . $path4;

            $question->save();
        } else {
            // TODO interactive questions
        }

        $question->categories()->sync($request->input('category') ?? []);

        return redirect()->route('question.show', $question);
    }

    public function filter()
    {
        return view('admin.question.filter');
    }

    public function saveFilter(Request $request)
    {
        $filter = array(
            'category' => $request->input('category'),
            'difficulty_from' => $request->input('difficulty_from'),
            'difficulty_to' => $request->input('difficulty_to'),
            'type' => $request->input('type'),
            'order' => $request->input('order')
        );

        Session::put('questionFilter', $filter);

        return redirect()->route('question.index');
    }

    public function resetFilter()
    {
        Session::put('questionFilter', null);
        return redirect()->route('question.index');
    }
}
