<?php

/**
 * Takes a comma-separated list of seat numbers and returns them
 * as a hyphenated range, separating non-contiguous seats by commas.
 */
if (! function_exists('getSeatSpan')) {
    function getSeatSpan(string $seatList): string
    {
        $seats = explode(',', $seatList);
        sort($seats, SORT_NUMERIC);

        $lowSeat = min($seats);

        if ($lowSeat === max($seats)) {
            return (string)$lowSeat;
        }

        $seatList = $lowSeat;

        $seatCount = count($seats);
        for ($i = 1; $i < $seatCount; $i++) {
            if (($seats[$i] === ($seats[$i - 1] + 1)) && ($i !== $seatCount - 1)) {
                if ((isset($seats[$i + 1])) && ($seats[$i] !== $seats[$i + 1] - 1)) {
                    $seatList .= '–'.$seats[$i];
                }
            } elseif (($i === $seatCount - 1) && ($seats[$i] === $seats[$i - 1] + 1)) {
                $seatList .= '–'.$seats[$i];
            } else {
                $seatList .= ','.$seats[$i];
            }
        }

        return $seatList;
    }
}


/**
 * Formats a ticket group location.
 */
if (! function_exists('formatTicketGroupLocation')) {
    function formatTicketGroupLocation(string $section, string $row, string $seats): string
    {
        return '<span class="ticket-group-location"><span class="ticket-group-section">'.$section.'</span>/<span class="ticket-group-row">'.$row.'</span>/<span class="ticket-group-seats">'.getSeatSpan($seats).'</span></span>';
    }
}



/**
 * Format an event date/time by first checking if the time is TBA
 * and removing any time formatting characters from the supplied format
 * and then append the TBA text instead.
 *
 * This function expects "00:00:00" as the TBA time which Ticket Evolution uses.
 */
if (! function_exists('getTbaFormat')) {
    function getTbaFormat(DateTime $datetime, string $format): string
    {
        if ($datetime->format('His') === '000000') {
            return $datetime->format(preg_replace(
                '/(?:[aABgGhHisuveIOPTZcr]| \\\a\\\t )+[ :]?[aABgGhHisuveIOPTZcr]*/',
                '',
                $format
            )).' TBA';
        }

        return $datetime->format($format);
    }
}
