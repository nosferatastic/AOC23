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


$file = fopen("input","r") or die("File not able to be opened");
$total = 0;
do {
    //open file
    $file_line = fgets($file);
    if(feof($file)) {
        break;
    }
    $calibrationValue = read_line($file_line);
    $total += (int) $calibrationValue;
} while (!feof($file));

echo $total;