<?php

function read_line($file_line) 
{
    //Trim out numbers, remove double spaces
    $trim1 = preg_replace('/\s+/', ' ',
        trim(
            substr($file_line,  strpos($file_line,":")+2, strpos($file_line,"|") - strpos($file_line,":")-2)
        )
    );
    $winners = explode(" ",$trim1);
    $trim2 = preg_replace('/\s+/', ' ',
        trim(
            substr($file_line,  strpos($file_line,"|")+2, strlen($file_line))
        )
    );
    $numbers = explode(" ",$trim2);
    return [$winners, $numbers];
}

function get_points(array $winners, array $my_numbers) {
    $score = 0;
    foreach($winners as $winner) {
        if(in_array($winner, $my_numbers)) {
            //WIN
            $score = ($score == 0 ? 1 : $score*2);
        }
    }
    return $score;
}

$file = fopen("input","r") or die("File not able to be opened");
$total_score = 0;
do {
    //open file
    $file_line = fgets($file);
    
    if(feof($file)) {
        break;
    }
    //Create 2D array of chars representing the input
    [$winners, $my_numbers] = read_line($file_line);

    $score = get_points($winners, $my_numbers);
    $total_score += $score;
    echo ("Game Score ".$score."\n");
    echo ("Total ".$total_score."\n");

} while (!feof($file));