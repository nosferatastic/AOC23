<?php

function has_symbol($data_array, $i, $j) {
    $has_symbol = false;
    //need to check i+1, i-1, j+1, j-1 all combos
    for($i2 = $i-1; $i2 <= $i+1; $i2++) {
        for($j2 = $j-1; $j2 <= $j+1; $j2++) {
            //Check it exists and isn't a newline or dot or number
            if(array_key_exists($i2,$data_array) && array_key_exists($j2,$data_array[$i2]) 
                && !is_numeric($data_array[$i2][$j2]) && $data_array[$i2][$j2] != '.' && $data_array[$i2][$j2] != "\n") {
                $has_symbol = $data_array[$i2][$j2];
                break;
            }
        }
        if($has_symbol) {
            break;
        }
    }
    return $has_symbol;
}

$file = fopen("input","r") or die("File not able to be opened");
$data_array = array();
$valid_numbers = array();
do {
    //open file
    $file_line = fgets($file);
    //Create 2D array of chars representing the input
    $data_array[] = str_split($file_line);
    if(feof($file)) {
        break;
    }
} while (!feof($file));
$output = 0;

//Go through the 2D array looking for number characters
for($i = 0; $i <= sizeof($data_array); $i++) {
    if(array_key_exists($i,$data_array)) {
        for($j = 0; $j <= sizeof($data_array[$i]); $j++) {
            if(array_key_exists($j,$data_array[$i]) && is_numeric($data_array[$i][$j])) {
                //Proceed through J iteration until no longer a number. With each number found, check if there's a symbol
                $has_symbol = false;
                $number = "";
                $symbol = "";
                while($j <= sizeof($data_array[$i]) && array_key_exists($j,$data_array[$i]) && is_numeric($data_array[$i][$j])) {
                    $number .= $data_array[$i][$j];
                    if(has_symbol($data_array, $i, $j)) {
                        $symbol = has_symbol($data_array,$i,$j);
                        $has_symbol = true;
                    }
                    $j++;
                }
                if($has_symbol) {
                    $output += $number;
                    echo("Number ".$number." matched to symbol ".$symbol.". Output now ".$output."\n");
                    $valid_numbers[] = $number;
                } else {
                    echo("Number ".$number." NO MATCH"."\n");
                }
            }
        }
    }
}

echo "TOTAL:".$output."\n";