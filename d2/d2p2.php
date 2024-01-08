<?php

function parse_game_string(string $game): array
{
    $moves = explode(";", $game);
    foreach($moves as $key1 => $move) {
        $moves[$key1] = explode(",", $move);
        foreach($moves[$key1] as $key2 => $pick) {
            $moves[$key1][$key2] = explode(" ",trim($pick));
        }
    }
    return $moves;
}

function get_game_power(string $game): int|boolval
{
    $gameNumber = substr($game, 5, strpos($game, ":") - 5);
    $game = parse_game_string(
        substr($game, strpos($game,":")+2)
    );
    $counts = [
        'red' => 0,
        'green' => 0,
        'blue' => 0
    ];

    foreach($game as $rounds) {
        foreach($rounds as $pick) {
            $count = $pick[0];
            $color = $pick[1];
            //We want the most possible things of this colour that have been shown. The minimum possible
            $counts[$color] = max($counts[$color], $count);
        }
    }
    //Power is the numbers of red, green, blue multiplied
    $power = $counts['red'] * $counts['green'] * $counts['blue'];
    return $power;
}

$file = fopen("testinput","r") or die("File not able to be opened");
$sum = 0;
do {
    //open file
    $file_line = fgets($file);
    if(feof($file)) {
        break;
    }
    $power = get_game_power($file_line);
    $sum += $power;
} while (!feof($file));

echo $sum;