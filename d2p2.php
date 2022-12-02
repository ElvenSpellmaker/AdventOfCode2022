<?php

$input = explode("\n", rtrim(file_get_contents('d2.txt')));

$gameScore = [
	'AX' => 3 + 0,
	'AY' => 1 + 3,
	'AZ' => 2 + 6,

	'BX' => 1 + 0,
	'BY' => 2 + 3,
	'BZ' => 3 + 6,

	'CX' => 2 + 0,
	'CY' => 3 + 3,
	'CZ' => 1 + 6,
];

$score = 0;

foreach ($input as $game)
{
	[$chose, $choose] = explode(' ', $game);

	$score += $gameScore[$chose . $choose];
}


echo $score, "\n";
