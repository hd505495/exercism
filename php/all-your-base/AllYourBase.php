<?php

declare(strict_types=1);

function rebase(int $fromBase, array $digits, int $toBase): array
{
    if ($fromBase < 2) {
        throw new InvalidArgumentException('input base must be >= 2');
    }

    if ($toBase < 2) {
        throw new InvalidArgumentException('output base must be >= 2');
    }

    if (count(array_filter($digits, fn ($d) => $d >= $fromBase || $d < 0))) {
        throw new InvalidArgumentException('all digits must satisfy 0 <= d < input base');
    }

    // if (!count($digits) || !count(array_filter($digits, fn ($d) => $d > 0))) {
    //     return [0];
    // }

    // calculate the actual value to operate on (using input array values as digits in base $fromBase)
    $reversed = array_reverse($digits);

    $value = 0;
    for ($i = 0; $i < count($reversed); $i++) {
        $value += $reversed[$i] * ($fromBase ** $i);
    }

    do {
		$output[] = $value % $toBase;
		$value /= $toBase;
	} while ($value > 0);

	return array_reverse($output);
}