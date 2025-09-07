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

    if (!count($digits) || !count(array_filter($digits, fn ($d) => $d > 0))) {
        return [0];
    }

    // calculate the actual value to operate on (using input array values as digits in base $fromBase)
    $reversed = array_reverse($digits);

    $value = 0;
    for ($i = 0; $i < count($reversed); $i++) {
        $value += $reversed[$i] * ($fromBase ** $i);
    }

    // find the largest power of toBase needed (this will be the length of the output array)
    $largestPower = 0;
    while ($value >= $toBase ** $largestPower && $value >= $toBase ** ($largestPower + 1)) {
        ++$largestPower;
    }

    // find values for each position in the new base
    $remainingValue = $value;
    for ($pow = $largestPower; $pow >= 0; $pow--) {
        $multiplier = 0;

        $valToTest = fn ($mult) => ($toBase ** $pow) * $mult;

        while (
            $valToTest($multiplier) <= $remainingValue
            && $valToTest($multiplier + 1) <= $remainingValue
        ) {
            ++$multiplier;
        }

        $remainingValue -= (($toBase ** $pow) * $multiplier);
        $output[] = $multiplier;
    }

    return $output;
}