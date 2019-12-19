<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use KubAT\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Storage;

class MigrateQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration file for questions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => 'http://btest.ibobor.sk',
            'cookies' => true,
            'auth' => ['risnyo96@gmail.com', 'risnyo96']
        ]);

        $response = $client->post('/index.php', [
            'form_params' => [
                'email' => 'risnyo96@gmail.com',
                'heslo' => 'risnyo96',
                'prihlasu' => 'Prihlásenie'
            ]
        ]);

        $allQuestions = [];

        for ($i = 1; $i < 522; $i++) {
            $response = $client->get('/ucitel/ulohy.php?uloha=' . $i);
            $responseStr = (string)$response->getBody();

            $parser = HtmlDomParser::str_get_html($responseStr);
            $section = $parser->find('section', 0);

            $data = $this->getQuestionDataFromHtmlDom($section);

            if ($data !== false) {
                echo "Parsing : " . $data['title'] . " .... \n";
                $questionData = $this->parseData($data);
                $allQuestions[] = $questionData;
            }
        }

        $contents = "<?php" . PHP_EOL . "return ";
        $contents .= var_export($allQuestions, true);
        $contents .= ";";
        File::put(storage_path() . '/appquestions.php', $contents);
    }

    private function parseData(&$data)
    {
        $isInserted = DB::table('questions')->where('title', $data['title'])->exists();
        if ($isInserted) {
            return false;
        }

        if ($data['type'] >= 4) {
            try {
                $image_a_url = str_replace('..', 'http://btest.ibobor.sk/', $data['a']);
                $image_b_url = str_replace('..', 'http://btest.ibobor.sk/', $data['b']);
                $image_c_url = str_replace('..', 'http://btest.ibobor.sk/', $data['c']);
                $image_d_url = str_replace('..', 'http://btest.ibobor.sk/', $data['d']);

                $image_a_name = substr($image_a_url, strrpos($image_a_url, '/') + 1);
                $image_b_name = substr($image_b_url, strrpos($image_b_url, '/') + 1);
                $image_c_name = substr($image_c_url, strrpos($image_c_url, '/') + 1);
                $image_d_name = substr($image_d_url, strrpos($image_d_url, '/') + 1);

                Storage::disk('public_uploads')->put('img/answers/' . $image_a_name, file_get_contents($image_a_url));
                Storage::disk('public_uploads')->put('img/answers/' . $image_b_name, file_get_contents($image_b_url));
                Storage::disk('public_uploads')->put('img/answers/' . $image_c_name, file_get_contents($image_c_url));
                Storage::disk('public_uploads')->put('img/answers/' . $image_d_name, file_get_contents($image_d_url));

                $data['a'] = '/img/answers/' . $image_a_name;
                $data['b'] = '/img/answers/' . $image_b_name;
                $data['c'] = '/img/answers/' . $image_c_name;
                $data['d'] = '/img/answers/' . $image_d_name;

            } catch (\Exception $exception) {
                return false;
            }
        }

        $html = HtmlDomParser::str_get_html($data['text']);
        $imgs = $html->find('img');

        if (count($imgs) == 0) {
            $data['question'] = $data['text'];
        } else {
            foreach ($imgs as $img) {
                try {
                    $image_url = str_replace('..', 'http://btest.ibobor.sk/', $img->src);
                    $image_name = substr($image_url, strrpos($image_url, '/') + 1);
                    Storage::disk('public_uploads')->put('img/questions/' . $image_name, file_get_contents($image_url));
                    $img->src = '/img/questions/' . $image_name;
                } catch (\Exception $exception) {
                    return false;
                }
            }
            $data['question'] = $html->outertext;
        }

        $difficulty = $this->getDifficultyFromString($data['difficulty']);
        if (!$difficulty) {
            return false;
        }

        $data['difficulty'] = $difficulty;

        $data['categories'] = $this->getCategoryIds($data['category']);

        unset($data['category']);
        unset($data['text']);

        return $data;
    }

    private function getDifficultyFromString($string)
    {
        $difficulties = explode(',', trim($string));

        for ($i = 0; $i < count($difficulties); $i++) {
            $difficulties[$i] = trim($difficulties[$i]);
        }

        if (count($difficulties) == 1) {
            if ($difficulties[0] == 'Bobrík') {
                return 1;
            } else if ($difficulties[0] == 'Benjamín') {
                return 2;
            } else if ($difficulties[0] == 'Kadet') {
                return 4;
            } else if ($difficulties[0] == 'Junior') {
                return 5;
            } else if ($difficulties[0] == 'Senior') {
                return 7;
            }
        }

        if (count($difficulties) == 2) {
            if ($difficulties[0] == 'Bobrík' && $difficulties[1] == 'Benjamín') {
                return 2;
            } else if ($difficulties[0] == 'Benjamín' && $difficulties[1] == 'Kadet') {
                return 3;
            } else if ($difficulties[0] == 'Kadet' && $difficulties[1] == 'Junior') {
                return 4;
            } else if ($difficulties[0] == 'Junior' && $difficulties[1] == 'Senior') {
                return 6;
            } else if ($difficulties[0] == 'Benjamín' && $difficulties[1] == 'Senior') {
                return 5;
            } else if ($difficulties[0] == 'Benjamín' && $difficulties[1] == 'Junior') {
                return 4;
            }
        }

        if (count($difficulties) == 3) {
            if ($difficulties[0] == 'Bobrík' && $difficulties[1] == 'Benjamín' && $difficulties[2] == 'Kadet') {
                return 3;
            } else if ($difficulties[0] == 'Benjamín' && $difficulties[1] == 'Kadet' && $difficulties[2] == 'Junior') {
                return 4;
            } else if ($difficulties[0] == 'Kadet' && $difficulties[1] == 'Junior' && $difficulties[2] == 'Senior') {
                return 6;
            }
        }

        if (count($difficulties) == 4) {
            if ($difficulties[0] == 'Bobrík' && $difficulties[1] == 'Benjamín' && $difficulties[2] == 'Kadet' && $difficulties[3] == 'Junior') {
                return 3;
            } else if ($difficulties[0] == 'Benjamín' && $difficulties[1] == 'Kadet' && $difficulties[2] == 'Junior' && $difficulties[3] == 'Senior') {
                return 5;
            }
        }

        if (count($difficulties) == 5) {
            return 4;
        }

        return 3;
    }

    private function getCategoryIds($cat)
    {
        $result = [];

        $categories = explode(',', $cat);

        for ($i = 0; $i < count($categories); $i++) {
            $categories[$i] = trim($categories[$i]);
        }

        foreach ($categories as $category) {
            switch ($category) {
                case 'DG':
                    $result[] = 2;
                    break;
                case 'ALG':
                    $result[] = 3;
                    break;
                case 'PC':
                    $result[] = 4;
                    break;
                case 'SPOL':
                    $result[] = 5;
                    break;

                case 'INF00':
                    $result[] = 1;
                    break;
                case 'INF01':
                    $result[] = 6;
                    break;
                case 'INF02':
                    $result[] = 7;
                    break;
                case 'INF03':
                    $result[] = 8;
                    break;
                case 'INF04':
                    $result[] = 9;
                    break;
                case 'INF05':
                    $result[] = 10;
                    break;
                case 'INF06':
                    $result[] = 11;
                    break;
                case 'INF10':
                    $result[] = 12;
                    break;
                case 'INF20':
                    $result[] = 13;
                    break;
                case 'INF30':
                    $result[] = 14;
                    break;
                case 'INF40':
                    $result[] = 15;
                    break;
                case 'INF50':
                    $result[] = 16;
                    break;
                case 'INF60':
                    $result[] = 17;
                    break;

                default:
                    break;
            }
        }
        return $result;
    }

    private function getQuestionDataFromHtmlDom($html)
    {
        $detail = $html->find('div.uloha_detail', 0);
        $answers = $html->find('div#dZadanie ol li');
        $text = $html->find('div#dZadanie', 0);

        if (count($answers) == 0 || count($html->find('object'))) {
            return false;
        }

        // basic info
        $data1 = $this->getMainQuestionDataFromStr($detail->innertext);

        // zadanie
        $data2 = $this->getQuestionTextFromHtml($text);

        // odpovede
        $data3 = $this->getQuestionAnswerDetails($answers);

        if ($data1 == false || $data2 == false || $data3 == false)
            return false;

        return array_merge($data1, $data2, $data3);
    }

    private function getQuestionTextFromHtml($html)
    {
        $html->find('ol', 0)->outertext = '';

        return array(
            'text' => $html->innertext
        );
    }

    private function getQuestionAnswerDetails($data)
    {
        $answer = null;
        $char = 'a';
        $result = [];

        $type = $this->getQuestionTypeFromAnswers($data);
        try {
            foreach ($data as $item) {
                if ($type < 4) {
                    $result[$char] = $item->plaintext;
                    $correct = $item->find('img');
                    if ($correct != null) {
                        $answer = $char;
                    }
                } else {
                    $imgs = $correct = $item->find('img');
                    $result[$char] = $imgs[0]->src;
                    if (count($imgs) > 1) {
                        $answer = $char;
                    }
                }

                $char++;
            }

            $result['type'] = $type;
            $result['answer'] = $answer;
        } catch (\Exception $exception) {
            return false;
        }
        return $result;
    }

    private function getQuestionTypeFromAnswers($data)
    {
        $is_img_type = false;
        $txt_count = 0;

        foreach ($data as $item) {
            $imgs = $item->find('img');
            if (count($imgs) > 1) {
                $is_img_type = true;
                break;
            }
            $txt_count += strlen($item->plaintext);
        }

        if ($is_img_type)
            return 4;

        $txt_avg = $txt_count / 4;

        if ($txt_avg < 11)
            return 3;

        if ($txt_avg < 30)
            return 2;

        return 1;
    }

    private function getMainQuestionDataFromStr($str)
    {
        $filteredStr = $this->removeTextFromStrongTags($str);

        $data = explode("<strong></strong>", trim($filteredStr));

        $finalData = [
            'title' => $data[1],
            'category' => $data[2],
            'difficulty' => $data[3],
            'year' => explode('<', $data[4])[0]
        ];

        return $finalData;
    }


    private function removeTextFromStrongTags($str)
    {
        return preg_replace('#(<strong.*?>).*?(</strong>)#', '$1$2', $str);
    }
}
