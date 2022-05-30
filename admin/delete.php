<?php

    include '_dbconn.php';

    $user_id = $_GET['id'];

    $query = "DELETE FROM users WHERE uid = $1";
    $r = pg_prepare($conn, "user_query", $query) or die ("Cannot prepare statement1\n");
    $r = pg_execute($conn, "user_query", array($user_id)) or die ("Cannot execute statement1\n");

    header("location: users.php");

?>