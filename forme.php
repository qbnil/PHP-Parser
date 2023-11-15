<?php
//
//$cars = array (
//    array("Volvo",22,18),
//    array("BMW",15,13),
//    array("Saab",5,2),
//    array("Land Rover",17,15)
//);
////$sliced_array = array_slice($cars, 1);
//for($i=1; $i<count($cars); $i++) {
//    for($j=0; $j<count($cars[$i]); $j++) {
//        echo $cars[$i][$j];
//    }
//    echo "\n";
//}

//$csvFile = file('OrderLog20181229.csv');
//$data = 'I,s,s,,e,';
//
//$data = explode(',', $data);
//print_r($data);


// Parse CSV data into an array
//foreach ($csvFile as $line) {
//    $data[] = str_getcsv($line, ';'); // Delimeter
//}

//print_r($data[0]);

//  have a GMT formatted String value in yyyy-MM-dd HH:mm:ss.SSS zzz
//
//eg: 2013-07-29 06:35:40:622 GMT. I want to get it as a date object and convert it into IST time zone.

// Custom time value
// The time format "HHMMSSZZZXXX" with a reference point of "с марта 2016" (meaning "from March 2016" in Russian) appears to be a custom format used to represent timestamps that count the number of milliseconds (ZZZ) and microseconds (XXX) since March 2016. Here's how you can convert this custom time format to a standard datetime format in PHP:
$customTime = "100000044124"; // Example value

// Convert milliseconds and microseconds to seconds
$milliseconds = substr($customTime, 0, 3);
$microseconds = substr($customTime, 9, 3);
$secondsSinceMarch2016 = intval($customTime / 1000);

// Create a DateTime object for March 2016
$referenceDate = new DateTime("2016-03-01");

// Add the calculated seconds to the reference date
$timestamp = $referenceDate->getTimestamp() + $secondsSinceMarch2016;

// Create a new DateTime object using the calculated timestamp
$dateTime = DateTime::createFromFormat('U.u', $timestamp . '.' . $microseconds);

// Format the DateTime object as a standard datetime string
$standardDatetime = $dateTime->format('Y-m-d H:i:s.u');

echo $standardDatetime;
