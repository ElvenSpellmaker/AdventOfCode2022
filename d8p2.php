<?php

/**
 * @var string[][]
 */
$input = array_map('str_split', explode("\n", rtrim(file_get_contents('d8.txt'))));

$rows = count($input);
$columns = count($input[0]);

$maxScore = -INF;
foreach ($input as $y => $row)
{
	foreach ($row as $x => $val)
	{
		$score = 0;

		$seenMinusY = 0;
		for ($dy = $y - 1; $dy >= 0; $dy--)
		{
			$seenMinusY++;
			if ($input[$dy][$x] >= $val)
			{
				break;
			}
		}

		$seenPlusY = 0;
		for ($dy = $y + 1; $dy < $rows; $dy++)
		{
			$seenPlusY++;
			if ($input[$dy][$x] >= $val)
			{
				break;
			}
		}

		$seenMinusX = 0;
		for ($dx = $x - 1; $dx >= 0; $dx--)
		{
			$seenMinusX++;
			if ($input[$y][$dx] >= $val)
			{
				break;
			}
		}

		$seenPlusX = 0;
		for ($dx = $x + 1; $dx < $columns; $dx++)
		{
			$seenPlusX++;
			if ($input[$y][$dx] >= $val)
			{
				break;
			}
		}

		$score = $seenMinusX * $seenMinusY * $seenPlusX * $seenPlusY;

		if ($score > $maxScore)
		{
			$maxScore = $score;
		}
	}
}

echo $maxScore, "\n";
