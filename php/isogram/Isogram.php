<?php

declare(strict_types=1);

function isIsogram(string $word): bool
{
    $chars = str_split(preg_replace('/[\s-]/', '', strtolower($word)));

    return array_unique($chars) === $chars;
}