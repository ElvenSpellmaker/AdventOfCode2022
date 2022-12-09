<?php

$input = explode("\n", rtrim(file_get_contents('d9.txt')));

$headX = 0;
$headY = 0;
$tailX = 0;
$tailY = 0;

$seen = ['0:0' => true];

foreach ($input as $line)
{
	preg_match('%([RDUL]) ([0-9]+)%', $line, $matches);

	for ($i = 0; $i < $matches[2]; $i++)
	{
		switch ($matches[1])
		{
			case 'U':
				$headY++;
			break;
			case 'D':
				$headY--;
			break;
			case 'R':
				$headX++;
			break;
			case 'L':
				$headX--;
			break;
		}

		$aroundX = [
			// Up
			sprintf('%s:%s', $headX, $headY + 1),
			// Top Right
			sprintf('%s:%s', $headX + 1, $headY + 1),
			// Right
			sprintf('%s:%s', $headX + 1, $headY),
			// Bottom Right
			sprintf('%s:%s', $headX + 1, $headY - 1),
			// Bottom
			sprintf('%s:%s', $headX, $headY - 1),
			// Bottom Left
			sprintf('%s:%s', $headX - 1, $headY - 1),
			// Left
			sprintf('%s:%s', $headX - 1, $headY),
			// Top Left
			sprintf('%s:%s', $headX - 1, $headY + 1),
		];

		$touchX = array_search(
			sprintf('%s:%s', $tailX, $tailY),
			$aroundX,
		);

		if ($touchX !== false || ($headX === $tailX && $headY === $tailY))
		{
			// echo "$headX, $headY -- $tailX, $tailY", "\n";
			continue;
		}

		$aroundY = [
			// Up
			sprintf('%s:%s', $tailX, $tailY + 1),
			// Top Right
			sprintf('%s:%s', $tailX + 1, $tailY + 1),
			// Right
			sprintf('%s:%s', $tailX + 1, $tailY),
			// Bottom Right
			sprintf('%s:%s', $tailX + 1, $tailY - 1),
			// Bottom
			sprintf('%s:%s', $tailX, $tailY - 1),
			// Bottom Left
			sprintf('%s:%s', $tailX - 1, $tailY - 1),
			// Left
			sprintf('%s:%s', $tailX - 1, $tailY),
			// Top Left
			sprintf('%s:%s', $tailX - 1, $tailY + 1),
		];

		$overlap = array_intersect($aroundX, $aroundY);
		foreach ($overlap as $overlapSquare)
		{
			[$newX, $newY] = explode(':', $overlapSquare);

			if ((int)$newX === $headX || (int)$newY === $headY)
			{
				$tailX = (int)$newX;
				$tailY = (int)$newY;

				$seen[sprintf('%s:%s', $newX, $newY)] = true;
				continue 2;
			}
		}
	}
}

echo count($seen), "\n";
