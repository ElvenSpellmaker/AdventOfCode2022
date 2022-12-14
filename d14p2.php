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

function moveSand(int $newX, int $newY, Sand $sand, int $floorY) : bool
{
	global $map;

	$bl = false;
	$br = false;

	process:
	$checkTile = $map[$newY][$newX] ?? null;

	if ($newY >= $floorY)
	{
		return true;
	}

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

$deepestY += 2;

while (true)
{
	if (count($movingSand) === 0)
	{
		if (isset($map[$sandPoint->y][$sandPoint->x]))
		{
			break;
		}

		$newSand = clone $sandPoint;
		$movingSand[] = $newSand;
		$map[$sandPoint->y][$sandPoint->x] = $newSand;
		continue;
	}

	foreach ($movingSand as $i => $sand)
	{
		$r = moveSand($sand->x, $sand->y + 1, $sand, $deepestY);

		if ($r === true)
		{
			$movingSand = [];

			$restedSand++;
		}
	}

	// for ($y = 0; $y < $deepestY + 4; $y++)
	// {
	// 	for ($x = 490; $x < 510; $x++)
	// 	{
	// 		echo isset($map[$y][$x])
	// 			? ($map[$y][$x] instanceof Sand
	// 				? (
	// 					isset($movingSand[0]) && $movingSand[0]->x === $x && $movingSand[0]->y === $y
	// 						? 'O'
	// 						: 'o'
	// 				)
	// 				: '#'
	// 			)
	// 			: '.';
	// 	}

	// 	echo "\n";
	// }

	// echo "\n";
}

echo $restedSand, "\n";
