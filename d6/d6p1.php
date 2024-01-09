<?php

function line_to_array($line) {
    $line = substr($line,10,strlen($line)-10);
    $line = preg_replace('/\s+/', ' ', $line);
    $store = explode(" ", trim($line));
    return $store;
}

function get_distance($total_time, $time_held) {
    $speed = $time_held;
    $time_traveling = $total_time - $time_held;
    $total_distance = $speed * $time_traveling;
    return $total_distance;
}

$file = fopen("input","r") or die("File not able to be opened");
//open file
//Store times
$file_line = fgets($file);
$times = line_to_array($file_line);
//Store record distances
$file_line = fgets($file);
$distance_records = line_to_array($file_line);

echo implode(",",$times)."\n";
echo implode(",",$distance_records)."\n";

$output_result = 1;

for($i = 0; $i < sizeof($times); $i++) {
    $wins = 0;
    echo "Race ".($i+1).". Record is ".$distance_records[$i]."\n";

    $possible_hold_times = range(0,$times[$i]);
    foreach($possible_hold_times as $hold_time) {
        $distance = get_distance($times[$i],$hold_time);
        //echo "Hold for ".$hold_time.", total distance ".$distance;
        if($distance > $distance_records[$i]) {
            $wins ++;
            //echo " WIN!\n";
        } else {
            //echo "\n";
        }
    }
    echo "Wins in Race ".($i+1).": ".$wins."\n";
    $output_result *= $wins;
}

echo "\nOutput Result: ".$output_result."\n";