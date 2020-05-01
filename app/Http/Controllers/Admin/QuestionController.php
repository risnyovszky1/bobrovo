<?php

namespace App\Http\Controllers\Admin;

use App\Rating;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Test;
use App\Question;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Input;
use Faker\Factory as Faker;

class QuestionController extends Controller
{

    // ====================================
    // |                                  |
    // |          TEACHER PAGES           |
    // |                                  |
    // ====================================


    // ---- QUESTIONS ----
    public function getAllQuestionsPage(Request $request)
    {
        $tests = DB::table('tests')
            ->select('id', 'name')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $questions = $this->getFilteredQuestions('all');

        return view('admin.questions_all', [
            'tests' => $tests,
            'questions' => $questions,
            'title' => 'Všetky otázky',
            'inputs' => $request->all(),
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


        switch ($q){
            case 'my':
                $query->where('created_by', Auth::user()->id);
                break;
            case 'other':
                $query->where('created_by', '!=', Auth::user()->id);
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
                $query->withCount(['comments as commentCount' => function ($query){
                    $query->select(DB::raw('coalesce(count(*),0)'));
                }]);
                $query->orderBy('commentCount', 'desc')
                    ->orderBy('title', 'asc');
            }
            if ($order == 3) {
                $query->withCount(['ratings as ratingAvg' => function ($query){
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }]);
                $query->orderBy('ratingAvg', 'desc')
                    ->orderBy('title', 'asc');
            }
            if ($order == 4) {
                $query->withCount(['ratings as ratingCount' => function ($query){
                    $query->select(DB::raw('coalesce(count(*),0)'));
                }]);
                $query->orderBy('ratingCount', 'desc')
                    ->orderBy('title', 'asc');
            }
            if ($order == 5) {
                $query->withCount(['tests as popularity' => function ($query){
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

    public function postAllQuestionsPage(Request $request)
    {
        $this->validate($request, [
            'questions' => 'required',
            'test-select' => 'required'
        ]);

        foreach ($request->input('questions') as $q) {
            $count = DB::table('question_test')
                ->where([
                    ['question_id', $q],
                    ['test_id', $request->input('test-select')]])
                ->count();

            if ($count == 0) {
                DB::table('question_test')->insert([
                    'question_id' => $q,
                    'test_id' => $request->input('test-select')
                ]);
            }
        }

        return redirect()->route('questions.all');
    }

    public function getMyQuestionsPage(Request $request)
    {
        $tests = DB::table('tests')
            ->select('id', 'name')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $questions = $this->getFilteredQuestions('my');

        return view('admin.questions_all', [
            'tests' => $tests,
            'questions' => $questions,
            'title' => 'Všetky otázky',
            'inputs' => $request->all(),
        ]);
    }

    public function postMyQuestionsPage(Request $request)
    {
        $this->validate($request, [
            'questions' => 'required',
            'test-select' => 'required'
        ]);

        foreach ($request->input('questions') as $q) {
            $count = DB::table('question_test')
                ->where([
                    ['question_id', $q],
                    ['test_id', $request->input('test-select')]])
                ->count();

            if ($count == 0) {
                DB::table('question_test')->insert([
                    'question_id' => $q,
                    'test_id' => $request->input('test-select')
                ]);
            }
        }

        return redirect()->route('questions.my');
    }

    public function getOtherQuestionsPage(Request $request)
    {
        $tests = DB::table('tests')
            ->select('id', 'name')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $questions = $this->getFilteredQuestions('other');

        return view('admin.questions_all', [
            'tests' => $tests,
            'questions' => $questions,
            'title' => 'Otázky od iných',
            'inputs' => $request->all(),
        ]);
    }

    public function getQuestionPage($id)
    {
        $question = Question::with('comments.user', 'ratings')->find($id);
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', 'users.id')
            ->select('comment', 'comments.created_at', 'first_name', 'last_name')
            ->where('question_id', $id)
            ->orderBy('created_at', 'ASC')
            ->get();

        $tests = DB::table('tests')
            ->select('id', 'name')
            ->where('teacher_id', Auth::user()->id)
            ->orderBy('name', 'ASC')
            ->get();

        $myRating = DB::table('ratings')
            ->select('rating')
            ->where([
                ['question_id', $id],
                ['user_id', Auth::user()->id]
            ])
            ->first();

        $categories = DB::table('question_category')
            ->join('categories', 'question_category.category_id', 'categories.id')
            ->select('name')
            ->where('question_id', $id)
            ->get();

        $avgTime = null;

        if (Auth::user()->is_admin) {
            $avgTime = DB::table('measurements')
                ->select('time_spent')
                ->where('question_id', $id)
                ->avg('time_spent');
        }


        return view('admin.questions_one', [
            'question' => $question,
            'comments' => $comments,
            'tests' => $tests,
            'myRating' => $myRating,
            'categories' => $categories,
            'avgTime' => $avgTime
        ]);
    }

    public function postQuestionPage(Request $request, $id)
    {
        $this->validate($request, [
            'test' => 'required'
        ]);

        $count = DB::table('question_test')
            ->where([
                ['question_id', $id],
                ['test_id', $request->input('test')],
            ])
            ->count();

        if ($count == 0) {
            DB::table('question_test')
                ->insert([
                    'question_id' => $id,
                    'test_id' => $request->input('test')
                ]);
        }

        return redirect()->route('questions.one', ['id' => $id]);
    }

    public function postAddComment(Request $request, $id)
    {
        $comment = new Comment([
            'user_id' => Auth::user()->id,
            'question_id' => $id,
            'comment' => $request->input('comment')
        ]);

        $comment->save();

        return redirect()->route('questions.one', ['id' => $id]);
    }

    public function getDeleteQuestion($id)
    {
        $question = Question::find($id);
        $question->delete();
        return redirect()->route('questions.all');
    }

    public function getEditQuestionPage($id)
    {
        $question = Question::find($id);
        $cat = DB::table('question_category')->select('category_id')->where('question_id', $id)->get();

        $categories = array();
        foreach ($cat as $c) {
            $categories[] = $c->category_id;
        }

        return view('admin.questions_edit', ['question' => $question, 'categories' => $categories]);
    }

    public function postEditQuestionPage(Request $request, $id)
    {
        $question = Question::find($id);

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

        DB::table('question_category')->where('question_id', $id)->delete();
        if ($request->input('category')) {
            foreach ($request->input('category') as $cat) {
                DB::table('question_category')->insert([
                    'question_id' => $id,
                    'category_id' => $cat
                ]);
            }
        }

        return redirect()->route('questions.one', ['id' => $id]);
    }

    public function getQuestionRating($id, $userRating)
    {
        $rating = Rating::where([
            ['question_id', $id],
            ['user_id', Auth::user()->id]
        ])->first();


        if ($rating) {
            $rating->update([
                'rating' => $userRating
            ]);
        } else {
            Rating::create([
                'question_id' => $id,
                'user_id' => Auth::user()->id,
                'rating' => $userRating
            ]);
        }

        return redirect()->route('questions.one', ['id' => $id]);
    }

    public function getAddQuestionPage()
    {

        return view('admin.questions_add');
    }

    public function postAddQuestionPage(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'type' => 'required',
            'difficulty' => 'required',
        ]);

        $type = intval($request->input('type'));

        if ($type >= 1 && $type <= 3) {
            // if type is text: in rows, in cols, 2x2
            $this->validate($request, [
                'answer-a' => 'required',
                'answer-b' => 'required',
                'answer-c' => 'required',
                'answer-d' => 'required',
            ]);

            $q = new Question([
                'title' => $request->input('title'),
                'question' => $request->input('question'),
                'a' => $request->input('answer-a'),
                'b' => $request->input('answer-b'),
                'c' => $request->input('answer-c'),
                'd' => $request->input('answer-d'),
                'answer' => $request->input('answer'),
                'type' => $type,
                'difficulty' => $request->input('difficulty'),
                'description' => $request->input('description') ? $request->input('description') : '',
                'description_teacher' => $request->input('description_teacher') ? $request->input('description_teacher') : '',
                'public' => $request->input('public') != null ? true : false,
                'created_by' => Auth::user()->id
            ]);

            $q->save();
        } else if ($type == 4) {
            // if type is img
            $this->validate($request, [
                'answer-a-img' => 'required',
                'answer-b-img' => 'required',
                'answer-c-img' => 'required',
                'answer-d-img' => 'required',
            ]);

            $q = new Question([
                'title' => $request->input('title'),
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'type' => $type,
                'difficulty' => $request->input('difficulty'),
                'description' => $request->input('description') ? $request->input('description') : '',
                'description_teacher' => $request->input('description_teacher') ? $request->input('description_teacher') : '',
                'public' => $request->input('public') != null ? true : false,
                'created_by' => Auth::user()->id,
                'a' => 'a',
                'b' => 'a',
                'c' => 'a',
                'd' => 'a',
            ]);

            $q->save();

            $path1 = $request->file('answer-a-img')->storeAs('img/answers', $q->id . 'a' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
            $path2 = $request->file('answer-b-img')->storeAs('img/answers', $q->id . 'b' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
            $path3 = $request->file('answer-c-img')->storeAs('img/answers', $q->id . 'c' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');
            $path4 = $request->file('answer-d-img')->storeAs('img/answers', $q->id . 'd' . '.' . $request->file('answer-a-img')->getClientOriginalExtension(), 'public_uploads');

            $q->a = '/' . $path1;
            $q->b = '/' . $path2;
            $q->c = '/' . $path3;
            $q->d = '/' . $path4;

            $q->save();
        } else {
            // if type is interactive
        }

        if ($request->input('category')) {
            foreach ($request->input('category') as $cat) {
                DB::table('question_category')->insert([
                    'question_id' => $q->id,
                    'category_id' => $cat
                ]);
            }
        }

        return redirect()->route('questions.one', ['id' => $q->id]);
    }

    public function getFilterPage()
    {
        return view('admin.questions_filter');
    }

    public function postFilterPage(Request $request)
    {
        $filter = array(
            'category' => $request->input('category'),
            'difficulty_from' => $request->input('difficulty_from'),
            'difficulty_to' => $request->input('difficulty_to'),
            'type' => $request->input('type'),
            'order' => $request->input('order')
        );

        Session::put('questionFilter', $filter);

        return redirect()->route('questions.all');
    }

    public function getFilterReset()
    {
        Session::put('questionFilter', null);
        return redirect()->route('questions.all');
    }
}
