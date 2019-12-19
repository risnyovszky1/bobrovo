<?php

use Illuminate\Database\Seeder;
use App\Question;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!File::exists(storage_path() . '/appquestions.php')) {
            return;
        }

        $questionRaws = File::getRequire(storage_path() . '/appquestions.php');

        if (!is_array($questionRaws)) {
            return;
        }

        foreach ($questionRaws as $questionRaw) {
            $data = empty($questionRaw['categories']) ? $questionRaw : Arr::except($questionRaw, ['categories']);

            if (!is_array($data) || !in_array($data['answer'], ["a", "b", "c", "d"])) {
                continue;
            }

            $question = Question::create($data);

            if (!empty($questionRaw['categories'])) {
                $question->categories()->sync($questionRaw['categories']);
            }
        }
    }
}
