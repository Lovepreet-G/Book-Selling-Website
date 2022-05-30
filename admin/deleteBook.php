<?php

    include '_dbconn.php';

    $book_id = $_GET['id'];

    $query = "DELETE FROM admin_book_table WHERE book_id = $1";
    $r = pg_prepare($conn, "user_query", $query) or die ("Cannot prepare statement1\n");
    $r = pg_execute($conn, "user_query", array($book_id)) or die ("Cannot execute statement1\n");

    header("location: books.php");

?>