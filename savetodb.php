
<?php
    include 'get-data.php';
    $csvFile = file('OrderLog20181229.csv');
    $data = array();


    // Parse CSV data into an array
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line, ';'); // Delimeter
    }
    $db = new SQLite3('tranzactions_data2.db');
    if (!$db) {
        die("Error connecting to a database.");
    }

    $db->exec('CREATE TABLE IF NOT EXISTS transactions (SECCODE TEXT, BUYSELL TEXT, TIME INTEGER, TRADENO INTEGER, PRICE REAL, VOLUME INTEGER)');
    for($i=1; $i < count($data); $i++) {
    //        $db->busyTimeout(5000);
    $stmt = $db->prepare('INSERT INTO transactions (SECCODE, BUYSELL, TIME, TRADENO, PRICE, VOLUME) VALUES (?, ?, ?, ?, ?, ?)');

    if ($stmt) {
    for ($j = 0; $j < count($data[$i]); $j++) {
    if ($j == 2)  {
    $formatted_time = (string) time_parser($data[$i][$j]);
    $stmt->bindParam(3, $formatted_time);
    }
    else{
    $stmt->bindParam($j + 1, $data[$i][$j]);
    }

    }


    $result = $stmt->execute();

    }

    }
    $db->close();