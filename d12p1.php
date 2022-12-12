<?php

/**
 * @var string[][]
 */
$input = array_map('str_split', explode("\n", rtrim(file_get_contents('d12.txt'))));

$nodes = [];
$nonInfNodes = [];
$startNode = [];
$endNode = [];

$dist = 1;

$rows = count($input);
$columns = count($input[0]);

class NodeMinHeap extends SplMinHeap
{
	public function compare($value1, $value2): int
	{
		return $value2['dist'] <=> $value1['dist'];
	}
}

function updateDistance(
	int $newNodeX,
	int $newNodeY,
	array &$nodes,
	array $checkChars,
	string $currChar,
	int $dist,
	array &$nonInfNodes
)
{
	$checkNode = &$nodes[$newNodeY][$newNodeX];
	if (in_array($checkNode['node'], $checkChars) || $currChar === '{' && $checkNode['node'] === 'E')
	{
		if ($dist <= $checkNode['dist'])
		{
			$checkNode['dist'] = $dist;

			$nonInfNodes[$newNodeY . ':' . $newNodeX] = $checkNode;
		}
	}
}

foreach ($input as $y => $nodeLine)
{
	foreach ($nodeLine as $x => $node)
	{
		$nodes[$y][$x] = ['node' => $node, 'dist' => INF, 'x' => $x, 'y' => $y];

		if ($node === 'S')
		{
			$startNode = $nodes[$y][$x];
			unset($nodes[$y][$x]);
		}

		if ($node === 'E')
		{
			$endNode = &$nodes[$y][$x];
		}
	}
}

$currentNode = $startNode;
$currChar = 'a';
while ($endNode['dist'] === INF)
{
	$checkChars = range('a', $currChar);

	// Top
	if ($currentNode['y'] - 1 >= 0)
	{
		updateDistance(
			$currentNode['x'],
			$currentNode['y'] - 1,
			$nodes,
			$checkChars,
			$currChar,
			$dist,
			$nonInfNodes,
		);
	}

	// Left
	if ($currentNode['x'] - 1 >= 0)
	{
		updateDistance(
			$currentNode['x'] - 1,
			$currentNode['y'],
			$nodes,
			$checkChars,
			$currChar,
			$dist,
			$nonInfNodes,
		);
	}

	// Right
	if ($currentNode['x'] + 1 < $columns)
	{
		updateDistance(
			$currentNode['x'] + 1,
			$currentNode['y'],
			$nodes,
			$checkChars,
			$currChar,
			$dist,
			$nonInfNodes,
		);
	}

	// Bottom
	if ($currentNode['y'] + 1 < $rows)
	{
		updateDistance(
			$currentNode['x'],
			$currentNode['y'] + 1,
			$nodes,
			$checkChars,
			$currChar,
			$dist,
			$nonInfNodes,
		);
	}

	unset($nonInfNodes[$currentNode['y'] . ':' . $currentNode['x']]);

	$heap = new NodeMinHeap;
	foreach ($nonInfNodes as $nonInfNode)
	{
		$heap->insert($nonInfNode);
	}

	$currentNode = $heap->extract();

	$currChar = chr(ord($currentNode['node']) + 1);

	$dist = $currentNode['dist'] + 1;
}

echo $endNode['dist'], "\n";
