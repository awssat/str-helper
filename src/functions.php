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
        return function_exists('app')
                    ? app('Illuminate\Support\Str')
                    : new Illuminate\Support\Str();
    }

    return new StrHelper($value);
}
