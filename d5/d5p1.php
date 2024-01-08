<?php

function map($mappings, $value) {
    //Mappings is an array of 3-element arrays containing "range start", "source range start", "range length".
    //If the value does not line up with specified mappings, it is itself.
    foreach($mappings as $map) {
        if($value >= $map[1] && $value < $map[1] + $map[2]) {
            //It's in there
            $output = $map[0] + ($value - $map[1]);
            return $output;
        }
    }
    return $value;
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
foreach($seeds as $seed) {
    $testSeed = $seed;
    $soil = map($seed_to_soil, $testSeed);
    $fert = map($soil_to_fert, $soil);
    $water = map ($fert_to_water, $fert);
    $light = map($water_to_light, $water);
    $temp = map($light_to_temp, $light);
    $hum = map($temp_to_hum, $temp);
    $loc = map($hum_to_loc, $hum);
    $lowest = !isset($lowest) ? $loc : min($loc, $lowest);
    echo($loc."\n");
}

echo "Lowest: ".$lowest."\n";