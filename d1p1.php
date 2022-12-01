<?php

$input = explode("\n\n", rtrim(file_get_contents('d1.txt')));

$maxSeen = -INF;
foreach ($input as $val)
{
	$sum = array_sum(explode("\n", $val));
	if ($sum > $maxSeen)
	{
		$maxSeen = $sum;
	}
}

echo $maxSeen, "\n";
