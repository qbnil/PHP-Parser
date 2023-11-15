<?php
require_once('paginator.php');
require_once('time_formatter.php');
require_once('connectcss.php');

$conn = new SQLite3('tranzactions_data2.db');

//      $limit = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 30;

$page = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;

$links = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;

$query = "SELECT * FROM transactions";

$paginator = new Paginator($conn, $query);
$results   = $paginator->getData($page);

$result = $conn->query('SELECT * FROM transactions');
$firstRow = $result->fetchArray(SQLITE3_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php linkResource("stylesheet", "style.css"); ?>
    <title>Document</title>
</head>
<body style="text-align: center">
<div class="container-fluid">

    <div>

        <table style="margin-top: 20px" class="table table-dark table-bordered table-rounded">
            <thead>
            <tr>
                <?php
                foreach (array_keys($firstRow) as $data) {
                    echo '<th>' . $data . '</th>';
                }
                ?>

            </tr>


            </thead>

            <tbody>
            <?php for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
                <tr>

                    <td><?php echo $results->data[$i]['SECCODE']; ?></td>

                    <td><?php echo $results->data[$i]['BUYSELL']; ?></td>

                    <td><?php echo $results->data[$i]['TIME']; ?></td>

                    <td><?php echo $results->data[$i]['TRADENO']; ?></td>

                    <td><?php echo $results->data[$i]['PRICE']; ?></td>
                    <td><?php echo $results->data[$i]['VOLUME']; ?></td>

                </tr>

            <?php endfor; ?>
            </tbody>
        </table>


    </div>

</div>

<?php echo $paginator->createLinks( $links, 'pagination justify-content-center pagination-lg' ); ?>


</body>
</html>

