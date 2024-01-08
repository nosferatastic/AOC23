<?php

function map_array($mappings, $values) {
    //For each value in the range, we check if it maps cleanly. If it doesn't, we split it accordingly and then map it.
    $neat_sort = false;
    $queue = $values;
    $output = array();
    while(!empty($queue)) {
        //Remove range to be checked for a mapping
        $range = array_shift($queue);
        //Variable stores if there has been mapping overlap found for the given range
        $in_a_mapping = false;
        foreach($mappings as $mapping) {
            //Case 1: It's within the mapping entirely, so we can just map
            if($range[0] >= $mapping[1] && $range[1] <= $mapping[1] + $mapping[2]) {
                $in_a_mapping = true;
                $output[] = [$mapping[0] + ($range[0] - $mapping[1]), $mapping[0] + ($range[1] - $mapping[1])];
                break;
            }
            //Case 2: It's overlapping the mapping. So we split it in two
            //2a overlapping bottom
            else if($range[0] < $mapping[1] && $range[1] > $mapping[1] && $range[1] < $mapping[1] + $mapping[2]) {
                $in_a_mapping = true;
                //We take two groups: start of range to start of mapping, and start of mapping to end of range
                $queue[] = [$range[0], $mapping[1]];
                if($mapping[1] < $range[1]) {
                    $queue[] = [$mapping[1], $range[1]];
                }
                break;
            }
            //2b overlapping top
            else if($range[0] > $mapping[1] && $range[0] < $mapping[1] + $mapping[2] && $range[1] > $mapping[1] + $mapping[2]) {
                $in_a_mapping = true;
                //We take two groups: start of mapping to end of range, an d end of range to end of mapping
                $queue[] = [$mapping[1], $range[1]];
                if($mapping[1] + $mapping[2] > $range[1]) {
                    $queue[] = [$range[1], $mapping[1] + $mapping[2]];
                }
                break;
            }
            //Case 4: It's outside the mapping completely. So we continue to next mapping
        }
        if(!$in_a_mapping) {
            //It's not in a mapping this range, so we can just return it as is
            $output[] = $range;
        }
    }
    return $output;
}

$file = fopen("input","r") or die("File not able to be opened");
$seeds = array();

$seed_to_soil = array();
$soil_to_fert = array();
$fert_to_water = array();
$water_to_light = array();
$light_to_temp = array();
$temp_to_hum = array();
$hum_to_loc = array();

do {
    $file_line = fgets($file);
}while(!str_starts_with($file_line,"seeds"));
//file_line contains seeds separate by space. Remove "seeds: " and then explode by space
$seeds = explode(" ", trim(substr($file_line, 6, strlen($file_line))));

//space
$file_line = fgets($file);
//title for seed-to-soil
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $seed_to_soil[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n");

//We are on the space, so now we skip the title and get initial map
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $soil_to_fert[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n");

//We are on the space, so now we skip the title and get initial map
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $fert_to_water[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n");

//We are on the space, so now we skip the title and get initial map
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $water_to_light[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n");

//We are on the space, so now we skip the title and get initial map
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $light_to_temp[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n");

//We are on the space, so now we skip the title and get initial map
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $temp_to_hum[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n");

//We are on the space, so now we skip the title and get initial map
$file_line = fgets($file);
//Initial map
$file_line = fgets($file);
do {
    //Read all mappings and store in array
    $hum_to_loc[] = explode(" ", trim($file_line));
   //$seed_to_soil[] = trim($file_line);
    $file_line = fgets($file);
} while ($file_line != "\n" && !feof($file));

//YAY! All the parsing is (hopefully) done

//So now we look for lowest location value by iteration of seeds through the mapping
$lowest = null;
$seed_groups = array_chunk($seeds, 2);
$min = INF;
foreach($seed_groups as [$seed_start, $length]) {
    //Start with a single array showing start and end
    $seed_range = [[$seed_start, $seed_start + $length - 1]];
    //Go through and map all ranges possible
    $soil = map_array($seed_to_soil, $seed_range);
    $fert = map_array($soil_to_fert, $soil);
    $water = map_array($fert_to_water, $fert);
    $light = map_array($water_to_light, $water);
    $temp = map_array($light_to_temp, $light);
    $hum = map_array($temp_to_hum, $temp);
    $loc = map_array($hum_to_loc, $hum);

    //$loc is now a 2D array of location ranges
    foreach($loc as $out) {
        //echo $out[0]." <<".$out[1]."\n";
        if($out[0] < $min) {
            $min = $out[0];
        }
    }
    $lowest = $min;
    echo("done group"."\n");
}

echo "Lowest: ".$min."\n";