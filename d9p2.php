<?php

$input = explode("\n", rtrim(file_get_contents('d9.txt')));

$rope = [
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
	[0, 0],
];

$seen = ['0:0' => true];

foreach ($input as $line)
{
	preg_match('%([RDUL]) ([0-9]+)%', $line, $matches);

	// echo $line, "\n";

	for ($i = 0; $i < $matches[2]; $i++)
	{
		switch ($matches[1])
		{
			case 'U':
				$rope[0][1]++;
			break;
			case 'D':
				$rope[0][1]--;
			break;
			case 'R':
				$rope[0][0]++;
			break;
			case 'L':
				$rope[0][0]--;
			break;
		}

		for ($j = 0; $j < 9; $j++)
		{
			$headX = $rope[$j][0];
			$headY = $rope[$j][1];

			$tailX = $rope[$j + 1][0];
			$tailY = $rope[$j + 1][1];

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

				if ((int)$newX === $headX || (int)$newY === $headY || count($overlap) === 1)
				{
					$rope[$j + 1][0] = (int)$newX;
					$rope[$j + 1][1] = (int)$newY;

					if ($j === 8)
					{
						$seen[sprintf('%s:%s', $newX, $newY)] = true;
					}

					break;
				}
			}
		}
	}
}

echo count($seen), "\n";
