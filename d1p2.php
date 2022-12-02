<?php

$input = explode("\n\n", rtrim(file_get_contents('d1.txt')));

$maxSeen = new SplMaxHeap;
foreach ($input as $val)
{
	$sum = array_sum(explode("\n", $val));
	$maxSeen->insert($sum);
}

echo $maxSeen->extract() + $maxSeen->extract() + $maxSeen->extract(), "\n";
