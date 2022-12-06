<?php

$input = rtrim(file_get_contents('d6.txt'));

$last4 = '';
$last3 = '';
$last2 = '';
for ($i = 0; $i < strlen($input); $i++)
{
	$check = [
		$input[$i] => true,
		$last2 => true,
		$last3 => true,
		$last4 => true,
	];

	if (! array_key_exists('', $check))
	{
		if (count($check) === 4)
		{
			break;
		}
	}

	$last4 = $last3;
	$last3 = $last2;
	$last2 = $input[$i];
}

echo $i + 1, "\n";
