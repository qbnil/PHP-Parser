<?php
      require_once('paginator.php');
      require_once('simple_html_dom.php');
      require_once('time_formatter.php');
      require_once('connectcss.php');

      $conn = new SQLite3('tranzactions_data2.db');


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
<!--    --><?php //header('Cache-Control: public, max-age=86400');
//          header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>PHP Parser</title>
</head>
<body style="text-align: center">
<h2 style="text-align: center;">Таблица для архивныx данныx за выбранный период о ценах и объемах сделок и заявок, необходимых для оптимизации торговых стратегий и алгоритмов, проведения технического анализа и нужд бэк-офисов, по любому рынку (акции, облигации, валютный, срочный) Группы "Московская Биржа".</h2>
<hr>
<!--<button id="load-data">Загрузить данные</button>-->
<!--<div id="data-container"></div>-->

<!--<script>-->
<!--    $('.pagination a.page-link').on('click', function(e) {-->
<!--        e.preventDefault();-->
<!--        $.ajax({-->
<!--            type: 'GET',-->
<!--            success: function(data) {-->
<!--                $('#data-container').html(data);-->
<!--                $('.pagination a.page-link.active').removeClass('active');-->
<!--                $(this).addClass('active');-->
<!--            }-->
<!--        });-->
<!--    });-->
<!---->
<!---->
<!--</script>-->



<!--<a href="--><?php //$_SERVER['PHP_SELF']; ?><!--" style="font-size: 20px">Reload</a>-->
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


<!--            echo '<tr>';-->
<!--            foreach (array_keys($firstRow) as $heading) {-->
<!--                echo '<th>' . $heading . '</th>';-->
<!--            }-->
<!--            echo '</tr>';-->
<!---->
<!--            $i = true;-->
<!--            while ($row = $result->fetchArray(SQLITE3_NUM)) {-->
<!--                if($i) {-->
<!--                    echo '<tr>';-->
<!--                    foreach (array_values($firstRow) as $data) {-->
<!--                        echo '<td>' . $data . '</td>';-->
<!--                    }-->
<!--                    echo '</tr>';-->
<!--                    $i = false;-->
<!--                }-->
<!---->
<!--                echo '<tr>';-->
<!---->
<!--                for ($i=0; $i<count($row); $i++) {-->
<!--                    echo '<td>' . array_values($row)[$i] . '</td>';-->
<!--                }-->
<!--            }-->
<!---->
<!---->
<!--                echo '</tr>';-->
<!---->
<!--            $db->close();-->
<!---->
<!--            ?>-->
        </table>
    </div>


            <?php echo $paginator->createLinks( $links, 'pagination justify-content-center pagination-lg' ); ?>


</body>
</html>

