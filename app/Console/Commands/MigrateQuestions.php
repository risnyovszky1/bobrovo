<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;

class MigrateQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:questions';

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

            if ($data !== false)
                $this->printArrayWithKeys($data);

            if ($i > 10) break;
        }
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
