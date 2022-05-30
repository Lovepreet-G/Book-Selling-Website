<?php

    $DNS = "host=localhost dbname=book user=postgres password=bookwebsite";
    $conn = pg_connect($DNS);

    if(!$conn) {
        die(pg_last_error($conn));
    }
?>
