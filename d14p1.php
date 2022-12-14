<?php

$input = explode("\n", rtrim(file_get_contents('d14.txt')));

$sandPoint = new Sand;
$sandPoint->x = 500;
$sandPoint->y = 0;
$map = [];

$deepestY = -INF;

// Otherwise known as Xand...
class Sand
{
	public $x;
	public $y;
}

function moveSand(int $newX, int $newY, Sand $sand) : bool
{
	global $map;

	$bl = false;
	$br = false;

	process:
	$checkTile = $map[$newY][$newX] ?? null;

	if ($checkTile === null)
	{
		unset($map[$sand->y][$sand->x]);

		$sand->x = $newX;
		$sand->y = $newY;

		$map[$sand->y][$sand->x] = $sand;

		return false;
	}

	if ($bl === false)
	{
		$bl = true;
		$newX--;

		goto process;
	}

	if ($br === false)
	{
		$br = true;
		$newX += 2;

		goto process;
	}

	return true;
}

foreach ($input as $line)
{
	preg_match_all('%(\d+),(\d+)%', $line, $matches);

	for ($i = 0; $i < count($matches[1]) - 1; $i++)
	{
		$xPoints = range($matches[1][$i], $matches[1][$i + 1]);
		$yPoints = range($matches[2][$i], $matches[2][$i + 1]);

		foreach ($xPoints as $xPoint)
		{
			foreach ($yPoints as $yPoint)
			{
				if ($yPoint > $deepestY)
				{
					$deepestY = $yPoint;
				}

				$map[$yPoint][$xPoint] = true;
			}
		}
	}
}

$movingSand = [];
$restedSand = 0;

while (true)
{
	if (count($movingSand) === 0)
	{
		$newSand = clone $sandPoint;
		$movingSand[] = $newSand;
		$map[$sandPoint->y][$sandPoint->x] = $newSand;
		continue;
	}

	foreach ($movingSand as $i => $sand)
	{
		if ($sand->y > $deepestY)
		{
			break 2;
		}

		$r = moveSand($sand->x, $sand->y + 1, $sand);

		if ($r === true)
		{
			$movingSand = [];

			$restedSand++;
		}
	}

	// for ($y = 0; $y < $deepestY + 1; $y++)
	// {
	// 	for ($x = 494; $x < 503; $x++)
	// 	{
	// 		echo isset($map[$y][$x])
	// 			? ($map[$y][$x] instanceof Sand
	// 				? 'o'
	// 				: '#'
	// 			)
	// 			: '.';
	// 	}

	// 	echo "\n";
	// }
}

echo $restedSand, "\n";
