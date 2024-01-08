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

function game_is_possible(string $game): int|boolval
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
    $maxCounts = [
        'red' => 12,
        'green' => 13,
        'blue' => 14
    ];

    foreach($game as $rounds) {
        foreach($rounds as $pick) {
            $count = $pick[0];
            $color = $pick[1];
            if(intval($count) > $maxCounts[$color]) {
                return false;
            }
            $counts[$color] += intval($count);
        }
    }
    /*
    if($counts['red'] <= 12
        && $counts['green'] <= 13
        && $counts['blue'] <= 14
    ) {
        return $gameNumber;
    }
    */
        return $gameNumber;
    //Else return false
    return false;
}

$file = fopen("input","r") or die("File not able to be opened");
$sum = 0;
do {
    //open file
    $file_line = fgets($file);
    if(feof($file)) {
        break;
    }
    if(game_is_possible($file_line)) {
        echo("good game".game_is_possible($file_line)."\n");
        $sum += game_is_possible($file_line);
    }
} while (!feof($file));

echo $sum;