<?php

$input = explode("\n", rtrim(file_get_contents('d7.txt')));

$sumDir = 0;
$maxSize = 100000;

// Class Setup
class File
{
	public $size;

	public function __construct(int $size)
	{
		$this->size = $size;
	}

	public function getSize() : int
	{
		return $this->size;
	}
}

class MyDirectory
{
	public $children = [];

	public function getSize() : int
	{
		global $sumDir, $maxSize;

		$size = 0;

		foreach ($this->children as $child)
		{
			$size += $child->getSize();
		}

		if ($size <= $maxSize)
		{
			$sumDir += $size;
		}

		return $size;
	}
}

// Parse input into structure
$root = new MyDirectory;
$currNode = $root;
$previousNodes = ['/' => $currNode];
foreach ($input as $line)
{
	$explode = explode(' ', $line);

	switch ($explode[0])
	{
		case '$':
			switch ($explode[1])
			{
				case 'ls':
					continue 3;
				break;
				case 'cd':
					switch ($explode[2])
					{
						case '..':
							$currNode = array_pop($previousNodes);
						break;
						case '/':
							continue 4;
						break;
						default:
							$previousNodes[] = $currNode;
							$currNode = $currNode->children[$explode[2]];
						break;
					}
				break;
			}
		break;
		case 'dir':
			$currNode->children[$explode[1]] = new MyDirectory;
		break;
		default:
			$currNode->children[$explode[1]] = new File($explode[0]);
		break;
	}
}

// Run size from Root
$root->getSize();

// Print largest size
echo $sumDir, "\n";
