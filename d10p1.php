<?php

$input = explode("\n", rtrim(file_get_contents('d10.txt')));

const ADD_AMOUNT_KEY = 'add_amount';

$lineCount = 0;
$cycle = 0;
$maxCycle = 220;

$signalStrength = 0;

$registerX = 1;
do
{
	$addx = explode(' ', $input[$lineCount]);

	cycleProcess:
	$cycle++;
	if (($cycle - 20) % 40 === 0)
	{
		$signalStrength += $cycle * $registerX;
	}

	if (count($addx) > 1)
	{
		$addx = [ADD_AMOUNT_KEY => $addx[1]];
		goto cycleProcess;
	}

	if (array_key_exists(ADD_AMOUNT_KEY, $addx))
	{
		$registerX += $addx[ADD_AMOUNT_KEY];
		$maxCycle--;
	}

	$lineCount++;
}
while ($maxCycle-- > 0);

echo $signalStrength, "\n";
