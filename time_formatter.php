<?php
function time_parser($timeint) {
    $timeint = (string) $timeint;
    $hour = substr($timeint, 0, 2);
    $minute = substr($timeint, 2, 2);
    $second = substr($timeint, 4, 2);
    $millis = substr($timeint, 6, 3);
    if(strlen($timeint) == 12) {
        $microsec = substr($timeint, 9, 3);
    }

    $dateTime = new DateTime();
    $dateTime->setTime((int) $hour, (int) $minute, (int) $second);

    if(strlen($timeint) == 9) {
        $formattedTime = $dateTime->format('H:i:s') . '.' . $millis;
    }
    else if (strlen($timeint) == 12) {
        $formattedTime = $dateTime->format('H:i:s') . '.' . $millis . $microsec;
    }
    else {
        throw new Exception('Неверный формат времени, не соответсвует: HHMMSSZZZXXX или HHMMSSZZZ');
    }


    return $formattedTime;
}

