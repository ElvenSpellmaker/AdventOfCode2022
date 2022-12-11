<?php

$input = array_map('explodeNewlines', explode("\n\n", rtrim(file_get_contents('d11.txt'))));

$rounds = 10000;

function explodeNewlines(string $str) : array
{
	return explode("\n", $str);
}

function square(int $a) : int
{
	return $a ** 2;
}

function multiply(int $a, int $b) : int
{
	return $a * $b;
}

function add(int $a, int $b) : int
{
	return $a + $b;
}

$monkeyItems = [];
$monkeyOperations = [];
$monkeyTests = [];
$monkeyInspections = [];
$monkeySharedModulo = 1;
foreach ($input as $monkey)
{
	// Monkey Number
	preg_match('%Monkey (\d)%', $monkey[0], $matches);
	$monkeyNumber = $matches[1];

	// Items
	preg_match_all('%\d+%', $monkey[1], $matches);
	$monkeyItems[$monkeyNumber] = $matches[0];

	// Operation
	preg_match('%(\*|\+) (\d+|old)$%', $monkey[2], $matches);
	$monkeyOperations[$monkeyNumber] = [
		'function' => $matches[1] === '*' ? 'multiply' : 'add',
		'amount' => $matches[2],
	];

	// Test
	preg_match('%\d+$%', $monkey[3], $matches);
	$monkeyTest = $matches[0];
	preg_match('%\d$%', $monkey[4], $matches);
	$trueMonkey = $matches[0];
	preg_match('%\d$%', $monkey[5], $matches);
	$monkeyTests[$monkeyNumber] = [
		'test' => $monkeyTest,
		true => $trueMonkey,
		false => $matches[0],
	];

	$monkeySharedModulo *= $monkeyTest;

	$monkeyInspections[$monkeyNumber] = 0;
}

while ($rounds--)
{
	foreach ($monkeyItems as $monkey => &$monkeyItemList)
	{
		foreach ($monkeyItemList as $monkeyItemKey => $monkeyItem)
		{
			$itemWorry = $monkeyOperations[$monkey]['amount'] === 'old'
				? square($monkeyItem)
				: $monkeyOperations[$monkey]['function']($monkeyItem, $monkeyOperations[$monkey]['amount']);

			$monkeyItems[$monkeyTests[$monkey][$itemWorry % $monkeyTests[$monkey]['test'] === 0]][] = $itemWorry % $monkeySharedModulo;

			unset($monkeyItems[$monkey][$monkeyItemKey]);

			$monkeyInspections[$monkey]++;
		}
	}
}


arsort($monkeyInspections);

echo reset($monkeyInspections) * next($monkeyInspections), "\n";
