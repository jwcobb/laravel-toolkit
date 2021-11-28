<?php

/**
 * Get a span of numbers from two given numbers.
 * Perfect for keeping the copyright date on a site updated using
 *     getNumberSpan($first, date('Y'))
 * and getting back '2015–2017' but never '2017–2017'
 */
if (! function_exists('getNumberSpan')) {
    function getNumberSpan(int $first, int $last): string
    {
        if ($last > $first) {
            return $first.'–'.$last;
        }

        return (string)$first;
    }
}

/**
 * Returns a phone number formatted as properly as we can determine.
 */
if (! function_exists('formatPhoneNumber')) {
    function formatPhoneNumber(string $number, string $format = 'ITUE123'): string
    {
        $newNum = $number;

        $cleanNumber = preg_replace('/\D/', '', $number);

        $length = strlen($cleanNumber);

        switch ($length) {
            case 13:
                $newNum = substr($cleanNumber, 0, 3).' '.substr($cleanNumber, 3, 3).' '.substr(
                        $cleanNumber,
                        6,
                        3
                    ).' '.substr($cleanNumber, 9, 4);
                break;

            case 12:
                $newNum = '+'.substr($cleanNumber, 0, 3).' '.substr($cleanNumber, 3, 2).' '.substr(
                        $cleanNumber,
                        5,
                        3
                    ).' '.substr($cleanNumber, 8, 4);
                break;

            case 11:
                if (substr($cleanNumber, 0, 1) == '1') {
                    $newNum = '+'.substr($cleanNumber, 0, 1).' '.substr(
                            $cleanNumber,
                            1,
                            3
                        ).' '.substr($cleanNumber, 4, 3).' '.substr($cleanNumber, 7, 4);
                } else {
                    $newNum = '+'.substr($cleanNumber, 0, 2).' '.substr(
                            $cleanNumber,
                            2,
                            2
                        ).' '.substr($cleanNumber, 4, 3).' '.substr($cleanNumber, 7, 4);
                }

                break;
            case 10:
                if ($format === 'hyphen') {
                    $newNum = substr($cleanNumber, 0, 3).'-'.substr($cleanNumber, 3, 3).'-'.substr(
                            $cleanNumber,
                            6,
                            4
                        );
                } else {
                    $newNum = '('.substr($cleanNumber, 0, 3).') '.substr(
                            $cleanNumber,
                            3,
                            3
                        ).'-'.substr($cleanNumber, 6, 4);
                }
                break;

            case 9:
                $newNum = substr($cleanNumber, 0, 2).' '.substr($cleanNumber, 2, 3).' '.substr(
                        $cleanNumber,
                        5,
                        2
                    ).' '.substr($cleanNumber, 7, 2);
                break;

            case 8:
                $newNum = substr($cleanNumber, 0, 4).' '.substr($cleanNumber, 3, 4);
                break;

            case 7:
                $newNum = substr($cleanNumber, 0, 3).'-'.substr($cleanNumber, 3, 4);
                break;

            default:
                $newNum = $cleanNumber;
        }

        return $newNum;
    }
}

/**
 * Takes a string that is supposed to be a tracking number and formats it in the
 * preferred form for that carrier.
 *
 * For FedEx that is "9999 9999 9999"
 * For UPS that is "1Z6W688A0295094892" (No reason to use spaces because it
 * still isn't readable)
 *
 * The extra long check (>31) is for cases where a FedEx label barcode is scanned.
 * Scanning results in a 32 digit number which has the desired airbill number
 * "buried" within.
 */
if (! function_exists('formatTrackingNumber')) {
    function formatTrackingNumber(string $trackingNumber, string $separator = ' '): string
    {

        $trimmedTrackingNumber = preg_replace('/\s/', '', $trackingNumber);
        $trimmedLength = strlen($trimmedTrackingNumber);

        if ($trimmedLength === 18) {
            // This is likely a UPS tracking number, just return it
            return $trimmedTrackingNumber;
        }

        // This is probably a FedEx tracking number
        $trimmedTrackingNumber = preg_replace('/[\D]/', '', $trackingNumber);
        $trimmedLength = strlen($trimmedTrackingNumber);

        if ($trimmedLength > 31) {
            return substr($trimmedTrackingNumber, 16, 4).$separator
                .substr($trimmedTrackingNumber, 20, 4).$separator
                .substr($trimmedTrackingNumber, 24, 4);
        }

        if ($trimmedLength > 8) {
            return substr($trimmedTrackingNumber, 0, 4).$separator
                .substr($trimmedTrackingNumber, 4, 4).$separator
                .substr($trimmedTrackingNumber, 8, 4);
        }

        return $trimmedTrackingNumber;
    }
}


/**
 * Get a string of stars to output for ratings.
 */
if (! function_exists('toStars')) {
    function toStars(float|int $rating, int $max = 5): string
    {
        if (! is_numeric($rating)) {
            return (string) $rating;
        }

        $string = str_repeat('★', floor($rating));
        if (($rating - floor($rating)) === .5) {
            $string .= '½';
        }

        return str_pad($string, $max, '☆', STR_PAD_RIGHT);
    }
}


/**
 * Convert camelCase to words.
 *
 * @link https://code.i-harness.com/en/q/44f73b#3
 */
if (! function_exists('camel_case_to_words')) {
    function camel_case_to_words(string $camelString): string
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $camelString));
    }
}



/**
 * Convert snake_case to words.
 */
if (! function_exists('snake_case_to_words')) {
    function snake_case_to_words(string $snakeString): string
    {
        return str_replace('_', ' ', $snakeString);
    }
}


/**
 * Truncate a string to a given length and put the original
 * string into a tooltip.
 *
 * @param string $string
 * @param int    $limit
 * @param string $placement
 * @param bool   $tooltipIfShort
 *
 * @return string
 */
if (! function_exists('truncateWithTooltip')) {
    function truncateWithTooltip(
        string $string,
        int $limit = 20,
        string $placement = 'top',
        bool $tooltipIfShort = false
    ): string {
        if (mb_strwidth($string, 'UTF-8') <= ($limit + 1)) {
            if ($tooltipIfShort === false) {
                return $string;
            }
            $truncatedString = $string;
        } else {
            $truncatedString = rtrim(mb_strimwidth($string, 0, $limit, '', 'UTF-8')).'…';
        }

        return '<span class="tooltip" data-placement="'.$placement.'" data-title="'.$string.'">'.$truncatedString.'</span>';
    }
}


if (! function_exists('trimToNull')) {
    function trimToNull(string|null $value): ?string
    {
        if (trim($value) === '') {
            return null;
        }

        return trim($value);
    }
}
