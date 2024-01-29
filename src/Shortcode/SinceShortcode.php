<?php

namespace QuinnInteractive\Orgsite\ShortCode;

use DateTime;

/*
 * Defaults to units=years
 * Examples:
 * [since units='years' date='Jan 1, 2000'] years
 * [since units='years' date='2000-01-01'] years
 * [since units='months' date='Jan 1, 2000'] months
 * [since units='days' date='Jan 1, 2000'] days
 * [since units='hours' date='Jan 1, 2000'] hours
 * [since units='minutes' date='Jan 1, 2000'] minutes
 * [since units='seconds' date='Jan 1, 2000'] seconds
 *
 */
class SinceShortcode
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

        // do nothing if no date
        if (empty($arguments['date'])) {
            return false;
        }

        $now = new DateTime();

        $then = new DateTime($arguments['date']);

        $units = $arguments['units'] ?? 'years';

        $interval = $then->diff($now);

        switch ($units) {
            case 'seconds':
                $format = '%s';
                break;

            case 'minutes':
                $format = '%i';
                break;

            case 'hours':
                $format = '%h';
                break;

            case 'days':
                $format = '%d';
                break;

            case 'months':
                $format = '%m';
                break;

            default: // years
                $format = '%y';
                break;
        }

        return $interval->format($format);
    }
}
