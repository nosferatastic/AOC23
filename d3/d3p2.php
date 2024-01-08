<?php

function fetch_number($data_array, $i, $j) {
    $start = $end = $j;
    while(array_key_exists($j,$data_array[$i]) && is_numeric($data_array[$i][$j])) {
        $start = $j;
        $j--;
    }
    $j = $end;
    while(array_key_exists($j,$data_array[$i]) && is_numeric($data_array[$i][$j])) {
        $end = $j;
        $j++;
    }
    $num = "";
    while($start <= $end) {
        $num .= $data_array[$i][$start];
        $start ++;
    }
    return $num;
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

//Go through the 2D array looking for * characters
for($i = 0; $i <= sizeof($data_array); $i++) {
    if(array_key_exists($i,$data_array)) {
        for($j = 0; $j <= sizeof($data_array[$i]); $j++) {
            if(array_key_exists($j,$data_array[$i]) && $data_array[$i][$j] == "*") {
                $numbers = [];

                //Retrieve all numbers around this. They will either be in the line above, below, or either side on same line.
                //Check same row
                    if(array_key_exists($j-1,$data_array[$i]) && is_numeric($data_array[$i][$j-1])) {
                        $numbers[] = fetch_number($data_array,$i,$j-1);
                    }
                    if(array_key_exists($j+1,$data_array[$i]) && is_numeric($data_array[$i][$j+1])) {
                        $numbers[] = fetch_number($data_array,$i,$j+1);
                }
                //Check above
                    if(array_key_exists($j-1,$data_array[$i-1]) && is_numeric($data_array[$i-1][$j-1])) {
                        $numbers[] = fetch_number($data_array,$i-1,$j-1);
                    }
                    //Only check j, j+1 if the space before it is not numeric (ie. it is a new number)
                    if(array_key_exists($j,$data_array[$i-1]) && is_numeric($data_array[$i-1][$j]) 
                    && (!array_key_exists($j-1,$data_array[$i-1]) || !is_numeric($data_array[$i-1][$j-1]))
                    ) {
                        $numbers[] = fetch_number($data_array,$i-1,$j);
                    }
                    if(array_key_exists($j+1,$data_array[$i-1]) && is_numeric($data_array[$i-1][$j+1]) 
                    && (!array_key_exists($j,$data_array[$i-1]) || !is_numeric($data_array[$i-1][$j]))
                    ) {
                        $numbers[] = fetch_number($data_array,$i-1,$j+1);
                    }
                //Check below
                    if(array_key_exists($j-1,$data_array[$i+1]) && is_numeric($data_array[$i+1][$j-1])) {
                        $numbers[] = fetch_number($data_array,$i+1,$j-1);
                    }
                    //Only check j, j+1 if the space before it is not numeric (ie. it is a new number)
                    if(array_key_exists($j,$data_array[$i+1]) && is_numeric($data_array[$i+1][$j]) 
                    && (!array_key_exists($j-1,$data_array[$i+1]) || !is_numeric($data_array[$i+1][$j-1]))
                    ) {
                        $numbers[] = fetch_number($data_array,$i+1,$j);
                    }
                    if(array_key_exists($j+1,$data_array[$i+1]) && is_numeric($data_array[$i+1][$j+1]) 
                    && (!array_key_exists($j,$data_array[$i+1]) || !is_numeric($data_array[$i+1][$j]))
                    ) {
                        $numbers[] = fetch_number($data_array,$i+1,$j+1);
                    }
                //If there are TWO numbers, this is a valid input
                if (sizeof($numbers) == 2) {
                    $output += $numbers[0]*$numbers[1];
                }
            }
        }
    }
}

echo "TOTAL:".$output."\n";