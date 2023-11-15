<?php
//date_default_timezone_set('UTC');
//$timestamp_unix = mktime('6', '2', '50', '1', '11', '2005' );
//$date = date($timestamp_unix);
//echo date("l", mktime(15, 54, 0, 9, 8, 2023));
//echo date('l');

$date = date_create('2000-01-01');
echo date_format($date, 'Y::m::d H:i:s');
