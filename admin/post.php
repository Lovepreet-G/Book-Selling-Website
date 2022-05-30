<?php

    include '_dbconn.php';

    $book_id = $_GET['id'];

    $query = "SELECT posted FROM admin_book_table WHERE book_id = $1";
    $r1 = pg_prepare($conn, "get_posted", $query) or die ("Cannot prepare statement1\n");
    $r1 = pg_execute($conn, "get_posted", array($book_id)) or die ("Cannot execute statement1\n");

    $r = pg_fetch_row($r1);
    
    if($r[0] == 't') {
        $query = "UPDATE admin_book_table SET posted = 'false' WHERE book_id = $1";
        $r2 = pg_prepare($conn, "query_send", $query) or die ("Cannot prepare statement1\n");
        $r2 = pg_execute($conn, "query_send", array($book_id)) or die ("Cannot execute statement1\n");
        header("location: books.php");
    } else if($r[0] == 'f') {
        $query = "UPDATE admin_book_table SET posted = 'true' WHERE book_id = $1";
        $r2 = pg_prepare($conn, "query_send", $query) or die ("Cannot prepare statement1\n");
        $r2 = pg_execute($conn, "query_send", array($book_id)) or die ("Cannot execute statement1\n");
        header("location: books.php");
    }

    

?>