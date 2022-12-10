<?php

$input = explode("\n", rtrim(file_get_contents('d10.txt')));

const ADD_AMOUNT_KEY = 'add_amount';

$lineCount = 0;
$cycle = 0;

$crtDisplay = [];

$registerX = 1;
do
{
	$addx = explode(' ', $input[$lineCount]);

	cycleProcess:
	$cycle++;

	$crtDisplay[] = in_array(($cycle - 1) % 40, [$registerX - 1, $registerX, $registerX + 1])
		? '#'
		: '.';

	if ($cycle % 40 === 0)
	{
		echo join('', $crtDisplay), "\n";
		$crtDisplay = [];
	}

	if (count($addx) > 1)
	{
		$addx = [ADD_AMOUNT_KEY => $addx[1]];
		goto cycleProcess;
	}

	if (array_key_exists(ADD_AMOUNT_KEY, $addx))
	{
		$registerX += $addx[ADD_AMOUNT_KEY];
	}
}
while (++$lineCount < count($input));
