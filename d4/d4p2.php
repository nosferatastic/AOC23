<?php

function read_line($file_line) 
{
    //Trim out numbers, remove double spaces
    $trim1 = preg_replace('/\s+/', ' ',
        trim(
            substr($file_line,  strpos($file_line,":")+2, strpos($file_line,"|") - strpos($file_line,":")-2)
        )
    );
    $winners = explode(" ",$trim1);
    $trim2 = preg_replace('/\s+/', ' ',
        trim(
            substr($file_line,  strpos($file_line,"|")+2, strlen($file_line))
        )
    );
    $numbers = explode(" ",$trim2);
    return [$winners, $numbers];
}

function get_match_count(array $winners, array $my_numbers) {
    $score = 0;
    foreach($winners as $winner) {
        if(in_array($winner, $my_numbers)) {
            //WIN
            $score += 1;
        }
    }
    return $score;
}

$file = fopen("input","r") or die("File not able to be opened");
$card_counts = [];
$card_games = [];
do {
    //open file
    $file_line = fgets($file);
    //We start off with one of each card
    $card_counts[] = 1;
    //Create 2D array of chars representing the inputs
    $card_games[] = read_line($file_line);
    
    if(feof($file)) {
        break;
    }

} while (!feof($file));

for($i = 0; $i < sizeof($card_counts); $i++) {
    //echo ($i);
    //Play game for i the required number of times, get score and add new cards
    $score = get_match_count($card_games[$i][0], $card_games[$i][1]);
    for($game_count = 0; $game_count < $card_counts[$i]; $game_count ++) {
        $tempScore = $score;
        while($tempScore > 0) {
            //Cannot add a card that doesn't exist
            if(array_key_exists($i + $tempScore, $card_counts)) {
                $card_counts[$i + $tempScore] += 1;
            }
            $tempScore --;
        }
    }
}
$card_total = 0;
foreach($card_counts as $c) {
    $card_total += $c;
}
foreach($card_counts as $i => $count) {
    echo "Card ".$i.": Have ".$count."\n";
}
echo $card_total."\n";