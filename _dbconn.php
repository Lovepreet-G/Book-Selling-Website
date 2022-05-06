<?php

    $DNS = "host=localhost dbname=book user=postgres password=book";
    $conn = pg_connect($DNS);

    if(!$conn) {
        die(pg_last_error($conn));
    }
?>