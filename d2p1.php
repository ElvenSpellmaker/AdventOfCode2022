<?php

$input = explode("\n", rtrim(file_get_contents('d2.txt')));

$gameScore = [
	'AX' => 1 + 3,
	'AY' => 2 + 6,
	'AZ' => 3 + 0,

	'BX' => 1 + 0,
	'BY' => 2 + 3,
	'BZ' => 3 + 6,

	'CX' => 1 + 6,
	'CY' => 2 + 0,
	'CZ' => 3 + 3,
];

$score = 0;

foreach ($input as $game)
{
	[$chose, $choose] = explode(' ', $game);

	$score += $gameScore[$chose . $choose];
}


echo $score, "\n";
