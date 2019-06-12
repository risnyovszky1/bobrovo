<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;
use App\Question;
use App\Category;
use Illuminate\Support\Facades\File;
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
    protected $description = 'Command description';

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
        // LOGIN TO THE OLD PAGE
        $data = array(
            'email' => 'risnyo96@gmail.com',
            'heslo' => 'risnyo96',
            'loginbtnUp' => '1',
            'submit_flag' => '1',
            'rand' => microtime(true),
            'formSubmitted' => 1    
        );
        

        $post_str = '';
        foreach($data as $key=>$val) {
            $post_str .= $key.'='.urlencode($val).'&';
        }
        $post_str = substr($post_str, 0, -1);
        $cookie_file = "cookie.txt";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://btest.ibobor.sk/' );
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($ch );
        //echo $response;
        curl_close($ch);

        // RETRIEVE QUESTION PAGES AFTER LOGIN
        for ($i = 1; $i < 522; $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://btest.ibobor.sk/ucitel/ulohy.php?uloha=' . $i);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
            $response = curl_exec($ch);
            curl_close($ch);

            $parser = HtmlDomParser::str_get_html($response);
            $section = $parser->find('section', 0);

            $data = $this->getQuestionDataFromHtmlDom($section);

            if ($data !== false){
                $this->printArrayWithKeys($data);

                $this->saveQuestion($data);
            }

            if ($i > 10) break;
        }
    }

    private function saveQuestion($data){
        $question = new Question([
            'title' => $data['title'],
            'description' => '  ',
            'description_teacher' => '   ',
            'type' => $data['type'],
            'answer' => $data['answer'],
            'created_by' => 1,
            'public' => 1
        ]);

        if ($data['type'] < 4){
            $question->a = $data['a'];
            $question->b = $data['b'];
            $question->c = $data['c'];
            $question->d = $data['d'];
        }
        else{
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

            $question->a = '/img/answers/' . $image_a_name;
            $question->b = '/img/answers/' . $image_b_name;
            $question->c = '/img/answers/' . $image_c_name;
            $question->d = '/img/answers/' . $image_d_name;
        }

        $html = HtmlDomParser::str_get_html($data['text']);
        $imgs = $html->find('img');

        if ($imgs == null){
            $question->question = $data['text'];
            $question->difficulty = 1;
            $question->save();

            echo "otazka pridany: " . $question->title;
            return true;
        }

        return false;

    }

    private function getCategoryId($cat){
        switch ($cat){
            case 'DG': return 2;
            case 'ALG': return 3;
            case 'PC': return 4;
            case 'SPOL': return 5;

            case 'INF00': return 1;
            case 'INF01': return 6;
            case 'INF02': return 7;
            case 'INF03': return 8;
            case 'INF04': return 9;
            case 'INF05': return 10;
            case 'INF06': return 11;
            case 'INF10': return 12;
            case 'INF20': return 13;
            case 'INF30': return 14;
            case 'INF40': return 15;
            case 'INF50': return 16;
            case 'INF60': return 17;

            default: break;
        }

        return false;
    }

    private function getQuestionDataFromHtmlDom($html){
        $detail = $html->find('div.uloha_detail', 0);
        $answers = $html->find('div#dZadanie ol li');
        $text = $html->find('div#dZadanie', 0);

        if (count($answers) == 0){
            return false;
        }
        // basic info
        $data1 = $this->getMainQuestionDataFromStr($detail->innertext);

        // zadanie
        $data2 = $this->getQuestionTextFromHtml($text);

        // odpovede
        $data3 = $this->getQuestionAnswerDetails($answers);

            //
        return array_merge($data1, $data2, $data3);
    }

    private function getQuestionTextFromHtml($html){
        $html->find('ol', 0)->outertext = '';

        return array(
            'text' => $html->innertext
        );
    }

    private function getQuestionAnswerDetails($data){
        $answer = null;
        $char = 'a';
        $result = [];

        $type = $this->getQuestionTypeFromAnswers($data);

        foreach ($data as $item){
            if ($type < 4){
                $result[$char] = $item->plaintext;
                $correct = $item->find('img');
                if ($correct != null){
                    $answer = $char;
                }
            }
            else{
                $imgs = $correct = $item->find('img');
                $result[$char] = $imgs[0]->src;
                if (count($imgs) > 1){
                    $answer = $char;
                }
            }

            $char++;
        }

        $result['type'] = $type;
        $result['answer'] = $answer;
        return $result;
    }

    private function getQuestionTypeFromAnswers($data){
        $is_img_type = false;
        $txt_count = 0;

        foreach ($data as $item){
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

    private function getMainQuestionDataFromStr($str){
        $filteredStr = $this->removeTextFromStrongTags($str);

        $data = explode("<strong></strong>", trim($filteredStr));

        $finalData = [
            'title' => $data[1],
            'category' => $data[2],
            'difficulty' => $data[3],
            'year' => explode('<',$data[4])[0]
        ];

        return $finalData;
    }


    private function removeTextFromStrongTags($str){
        return preg_replace('#(<strong.*?>).*?(</strong>)#', '$1$2', $str);
    }


    private function printArray($data){
        for ($i = 0; $i < count($data); $i++){
            echo " " . $i . ". " . $data[$i] . "\n";
        }
    }

    private function printArrayWithKeys($data){
        $keys = array_keys($data);

        foreach ($keys as $key){
            echo " " . $key . ": ". $data[$key] . "\n";
        }

        echo "=========\n\n";
    }
}
