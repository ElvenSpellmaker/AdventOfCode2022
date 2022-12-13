<?php

function split_newlines(string $str) : array
{
	return explode("\n", $str);
}

$input = array_map('split_newlines', explode("\n\n", rtrim(file_get_contents('d13.txt'))));

function workOutArray(array $left, array $right)
{
	for ($i = 0; $i < count($left); $i++)
	{
		if (! array_key_exists($i, $right))
		{
			return false;
		}

		if (! array_key_exists($i, $left))
		{
			return true;
		}

		if (is_array($left[$i]) || is_array($right[$i]))
		{
			if (! is_array($left[$i]))
			{
				$left[$i] = [$left[$i]];
			}

			if (! is_array($right[$i]))
			{
				$right[$i] = [$right[$i]];
			}

			$r = workOutArray($left[$i], $right[$i]);

			if ($r === true || $r === false)
			{
				return $r;
			}

			continue;
		}

		if ($left[$i] < $right[$i])
		{
			return true;
		}

		if ($left[$i] > $right[$i])
		{
			return false;
		}
	}

	if ($i === count($right))
	{
		return null;
	}

	return $i < count($right);
}

$workArray = [
	[[2]],
	[[6]],
];
foreach($input as [$left, $right])
{
	$workArray[] = eval("return $left;");
	$workArray[] = eval("return $right;");
}

$index = 1;
$indexSum = 0;

usort($workArray, function($a, $b) {
	return workOutArray($b, $a);
});

echo (array_search([[2]], $workArray) + 1) * (array_search([[6]], $workArray) + 1), "\n";
