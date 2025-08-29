<?php

declare(strict_types=1);

function encode(string $input): string
{
    if (!strlen($input)) return '';

    $output = '';
    $chars = str_split($input);

    $tracker = [];
    $currentTrackerIndex = 0;
    $tracker[] = ['val' => $chars[0], 'freq' => 1];

    for ($i = 1; $i < count($chars); $i++) {
        if ($tracker[$currentTrackerIndex]['val'] === $chars[$i]) {
            ++$tracker[$currentTrackerIndex]['freq'];
        } else {
            ++$currentTrackerIndex;
            $tracker[] = [
                'val' => $chars[$i],
                'freq' => 1
            ];
        }
    }

    for ($j = 0; $j < count($tracker); $j++) {
        if ($tracker[$j]['freq'] === 1) {
            $output .= $tracker[$j]['val'];
        } else {
            $concat = ((string) $tracker[$j]['freq']) . $tracker[$j]['val'];
            $output .= $concat;
        }
    }

    return $output;
}

function decode(string $input): string
{
    if (!strlen($input)) return '';

    $output = '';
    $count = '';


    for ($i = 0; $i < strlen($input); $i++) {
        if (is_numeric($input[$i])) {
            $count .= $input[$i];
        } else {
            $count = $count === '' ? 1 : intval($count);

            for ($j = 0; $j < $count; $j++) {
                $output .= $input[$i];
            }

            $count = '';
        }
    }

    return $output;
}
