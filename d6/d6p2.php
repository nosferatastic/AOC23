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

$output_result = 1;
$time_total = $dis_total = "";

//We concatenate the times and distances as required
for($i = 0; $i < sizeof($times); $i++) {
    $time_total .= $times[$i];
    $dis_total .= $distance_records[$i];
}
//Then make new times/distances array with just these!
$times = [ $time_total ];
$distance_records = [ $dis_total ];

for($i = 0; $i < sizeof($times); $i++) {
    $wins = 0;
    echo "Race ".($i+1).". Record is ".$distance_records[$i]."\n";

    for($j = 0; $j <= $times[$i]; $j++) {
        $distance = get_distance($times[$i],$j);
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