<?php

$input = rtrim(file_get_contents('d6.txt'));

$last14 = '';
$last13 = '';
$last12 = '';
$last11 = '';
$last10 = '';
$last9 = '';
$last8 = '';
$last7 = '';
$last6 = '';
$last5 = '';
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
		$last5 => true,
		$last6 => true,
		$last7 => true,
		$last8 => true,
		$last9 => true,
		$last10 => true,
		$last11 => true,
		$last12 => true,
		$last13 => true,
		$last14 => true,
	];

	if (! array_key_exists('', $check))
	{
		if (count($check) === 14)
		{
			break;
		}
	}

	$last14 = $last13;
	$last13 = $last12;
	$last12 = $last11;
	$last11 = $last10;
	$last10 = $last9;
	$last9 = $last8;
	$last8 = $last7;
	$last7 = $last6;
	$last6 = $last5;
	$last5 = $last4;
	$last4 = $last3;
	$last3 = $last2;
	$last2 = $input[$i];
}

echo $i + 1, "\n";
