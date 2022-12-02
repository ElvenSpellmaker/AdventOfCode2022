<?php

$input = explode("\n", rtrim(file_get_contents('d2.txt')));

$gameScore = [
	'A X' => 3 + 0,
	'A Y' => 1 + 3,
	'A Z' => 2 + 6,

	'B X' => 1 + 0,
	'B Y' => 2 + 3,
	'B Z' => 3 + 6,

	'C X' => 2 + 0,
	'C Y' => 3 + 3,
	'C Z' => 1 + 6,
];

$score = 0;

foreach ($input as $game)
{
	$score += $gameScore[$game];
}


echo $score, "\n";
