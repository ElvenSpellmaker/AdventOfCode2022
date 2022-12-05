<?php

[$stacks, $instructions] = explode("\n\n", rtrim(file_get_contents('d5.txt')));

$stacks = explode("\n", $stacks);
$instructions = explode("\n", $instructions);

$stacksLists = [];

for ($i = count($stacks) - 2; $i >= 0; $i--)
{
	preg_match_all('%\[([A-Z])\] ?|(?:   ) ?%', $stacks[$i], $matches);
	foreach ($matches[1] as $index => $match)
	{
		if ($match !== '')
		{
			$stacksLists[$index][] = $match;
		}
	}
}

foreach ($instructions as $instruction)
{
	preg_match('%move (\d+) from (\d+) to (\d+)%', $instruction, $matches);

	$moveAmount = $matches[1];
	$from = $matches[2] - 1;
	$to = $matches[3] - 1;

	$movePile = [];
	for ($i = 0; $i < $moveAmount; $i++)
	{
		$thing = array_pop($stacksLists[$from]);

		$movePile[] = $thing;
	}

	$movePile = array_reverse($movePile);

	foreach ($movePile as $moveThing)
	{
		$stacksLists[$to][] = $moveThing;
	}
}

foreach ($stacksLists as $stacksList)
{
	echo end($stacksList);
}

echo "\n";
