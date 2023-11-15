<?php
$opts = [
    'http' => [
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
        'header' => 'Content-type: text/html'
    ]
];
$context = stream_context_create($opts);
$references = array();

$html = file_get_contents('https://www.moex.com/ru/orders?historicaldata', false, $context);
$hrefToFind = 'https://fs.moex.com/files/18310';
$domHtml = str_get_html($html);
foreach ($domHtml->find('a') as $element) {
    array_push($references, $element) . "\r\n";
}
foreach ($references as $element) {
    $href = $element->getAttribute('href');
    if ($href === $hrefToFind) {
        $zip_file = 'sample.zip';
        // Downloading the file
        file_put_contents($zip_file, file_get_contents($href));

        $unzip = new ZipArchive();
        $out = $unzip->open('sample.zip');
        if ($out === TRUE) {
            $unzip->extractTo(getcwd());
            $unzip->close();
            echo '<h1 style="text-align: center">' . 'File was unzipped successfully the table for it is right down below' . '</h1>';
            echo('<hr>');
        } else {
            echo 'Error occured when unzipping a file';
        }

    }
}
?>