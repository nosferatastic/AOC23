<?php

function read_line(string $input): int
{
    $firstInt = $lastInt = null;
    foreach(str_split($input) as $key => $character) {
        if(is_numeric($character)) {
            if(is_null($firstInt)) {
                $firstInt = $character;
            }
            $lastInt = $character;
        }
    }
    return intval($firstInt."".$lastInt);
}

function replace_digit_strings(string $input): string
{

    $digit_strings = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine'
    ];
    foreach($digit_strings as $int => $string) {
        $input = str_replace($string, $string.$int.$string, $input);
    }
    return $input;
}


$file = fopen("input","r") or die("File not able to be opened");
$total = 0;
do {
    //open file
    $file_line = fgets($file);
    if(feof($file)) {
        break;
    }
    echo($file_line."\n");
    $file_line = replace_digit_strings($file_line);
    echo($file_line."\n");
    $calibrationValue = read_line($file_line);
    $total += (int) $calibrationValue;
} while (!feof($file));

echo $total;