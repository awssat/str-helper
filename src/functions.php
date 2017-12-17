<?php

use Awssat\StrHelper\StrHelper;

/**
 * A flexible & powerful string manipulation helper for Laravel.
 *
 * @param string $value a string, or leave it empty to get an instance of Str
 *
 * @author abdumu <hi@abdumu.com>
 *
 * @return mixed|Illuminate\Support\Str|Awssat\StrHelper\StrHelper
 */
function str($value = null)
{
    if ($value === null) {
        if (class_exists('\\Illuminate\\Support\\Str')) {
            return function_exists('app')
                    ? app('Illuminate\Support\Str')
                    : new Illuminate\Support\Str();
        } else {
            return $value;
        }
    }

    return new StrHelper($value);
}
