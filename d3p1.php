<?php

$input = explode("\n", rtrim(file_get_contents('d3.txt')));

$sum = 0;
foreach ($input as $rucksack)
{
	$strlen = strlen($rucksack);
	[$comp1, $comp2] = str_split($rucksack, $strlen / 2);

	$crossover = array_intersect(str_split($comp1), str_split($comp2));
	$crossover = ord(array_pop($crossover));
	$sum += $crossover - ($crossover > 96 ? 96 : 38);
}

echo $sum, "\n";
