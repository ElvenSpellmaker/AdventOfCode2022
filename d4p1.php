<?php

$input = explode("\n", rtrim(file_get_contents('d4.txt')));

$sum = 0;
foreach ($input as $line)
{
	preg_match('%(\d+)-(\d+),(\d+)-(\d+)%', $line, $matches);

	$left = range($matches[1], $matches[2]);
	$right = range($matches[3], $matches[4]);

	$crossover = array_values(array_intersect($left, $right));

	$sum += $left === $crossover || $right === $crossover;
}

echo $sum , "\n";
