<?php

/**
 * @var string[][]
 */
$input = array_map('str_split', explode("\n", rtrim(file_get_contents('d8.txt'))));

$rows = count($input);
$columns = count($input[0]);

$visible = 0;
foreach ($input as $y => $row)
{
	foreach ($row as $x => $val)
	{
		if ($y === 0 || $x === 0 || $y === $rows - 1 || $x === $columns - 1)
		{
			$visible++;
			continue;
		}

		$seenMinusY = false;
		for ($dy = $y - 1; $dy >= 0; $dy--)
		{
			if ($input[$dy][$x] >= $val)
			{
				$seenMinusY = true;
				break;
			}
		}

		$seenPlusY = false;
		for ($dy = $y + 1; $dy < $rows; $dy++)
		{
			if ($input[$dy][$x] >= $val)
			{
				$seenPlusY = true;
				break;
			}
		}

		$seenMinusX = false;
		for ($dx = $x - 1; $dx >= 0; $dx--)
		{
			if ($input[$y][$dx] >= $val)
			{
				$seenMinusX = true;
				break;
			}
		}

		$seenPlusX = false;
		for ($dx = $x + 1; $dx < $columns; $dx++)
		{
			if ($input[$y][$dx] >= $val)
			{
				$seenPlusX = true;
				break;
			}
		}

		$visible += $seenMinusX === false || $seenMinusY === false || $seenPlusX === false || $seenPlusY === false;
	}
}

echo $visible, "\n";
