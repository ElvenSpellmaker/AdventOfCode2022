<?php

$input = explode("\n", rtrim(file_get_contents('d3.txt')));

$sum = 0;
for ($i = 0; $i < count($input); $i += 3)
{
	$crossover = array_intersect(str_split($input[$i]), str_split($input[$i + 1]), str_split($input[$i + 2]));
	$crossover = array_pop($crossover);
	$sum += ord($crossover) > 96 ? ord($crossover) - 96 : ord($crossover) - 38;
}

echo $sum, "\n";
