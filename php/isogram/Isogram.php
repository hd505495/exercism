<?php

declare(strict_types=1);

function isIsogram(string $word): bool
{
    $freq = [];
    $chars = str_split($word);

    for ($i = 0; $i < count($chars); $i++) {
        if (ctype_alpha($chars[$i])) {
            $char = strtolower($chars[$i]);

            if (array_key_exists($char, $freq)) {
                ++$freq[$char];
            } else {
                $freq[$char] = 1;
            }
        }
    }

    return count(array_filter($freq, fn ($val) => $val > 1)) === 0;
}