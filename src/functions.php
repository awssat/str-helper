<?php

use Awssat\StrHelper\StrHelper;

if (! function_exists('str')) {
    /**
     * A flexible & powerful string manipulation helper for PHP.
     *
     * @param string $value a string
     *
     * @author abdumu <hi@abdumu.com>
     *
     * @return mixed|Awssat\StrHelper\StrHelper
     */
    function str($value = null)
    {
        return new StrHelper($value);
    }
}
