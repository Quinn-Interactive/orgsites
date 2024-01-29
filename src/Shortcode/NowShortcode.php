<?php

namespace QuinnInteractive\Orgsite\ShortCode;

use DateTime;

/*
 * Return formattable now date/time, formatted with PHP Date formatting
 * https://www.php.net/manual/en/datetime.format.php
 * 
 * Examples:
 * [now] - January 29, 2024 05:22:31 PM
 * [now format='Y-m-d H:i:s'] - 2024-01-29 17:22:31
 *
 */
class NowShortcode
{
    /**
     * @psalm-param array{date: mixed, units: mixed} $arguments
     *
     * @return false|string
     */
    public static function shortcode_handler(array $arguments, $caption = null, $parser = null): string|false
    {
        // force keys to lowercase
        $arguments = array_change_key_case($arguments, CASE_LOWER);

        $now = new DateTime();
        $format = $arguments['format'] ?? 'F d, Y h:i:s A';

        return $now->format($format);
    }
}
