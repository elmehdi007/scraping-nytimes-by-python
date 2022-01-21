
<style type="text/css">span.highlights{ background-color:#c0ffc8; font-weight: 700;}</style>
<?php error_reporting(E_ALL); ?>
<?php

function sortByStringLenght($a,$b){return strlen($b)-strlen($a);}

function highlights_word_in_text(string $text):string{

    $transform_text = strtolower(trim($text));
    $all_words = array_filter(explode(" ", $text), function($item){return trim($item);});
    usort($all_words,'sortByStringLenght');
    $highlights_text = $text;
    $list_words_highlighted = [];
    define("EXCLAUDE_CAR",["",".",":",",",";","?","!","@","…",'"']);
    define("EXCLAUDE_WORDS",["the", "about", "can", "could", "may", "might", "must", "shall", "should", "will", 
            "would", "ought",
            "first", "firstly", "second" , "secondly", "third" , "thirdly", "etc",
            "next", "last", "finally", "moreover", "further" , "furthermore", "also",
            "after","before", "which" ,"from"
    ]);

    // use my method to highlights_word by searchin words by loop 
    $highlights_text_tab= [];
    foreach (explode(" ", $text) as $key => $word) {
            $transform_value = strtolower(strip_tags(trim($word)));
            
            if($transform_value == "") continue;

            if(substr_count($transform_text, $transform_value)>1
                && !in_array($text,$list_words_highlighted)
                && strlen(str_replace(EXCLAUDE_CAR,'',($transform_value)))>3
                && !in_array(str_ireplace(EXCLAUDE_CAR,'',$transform_value),EXCLAUDE_WORDS)
                ){
                $highlights_text_tab[] = str_replace("$word",'<span class="highlights">'.($word).'</span>',$word);
                $list_words_highlighted[] = $transform_value;
            }

            else {
                $highlights_text_tab[] = $word;
            }
    } 
        
    $highlights_text = join(' ',$highlights_text_tab);
    
    return '<p>'.$highlights_text. '</p>';
}



try {
    //$text = " est Ceci est est un test est <br/>fdgdfg est <br/>";
    $text = file_get_contents("./accesoire.txt");
    echo(highlights_word_in_text($text));
} catch (\Throwable $th) {
    var_dump($th);
}
