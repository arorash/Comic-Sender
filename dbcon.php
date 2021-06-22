<?php
    $server = getenv('HOST');
    $user = getenv('USER_ID');
    $pass = getenv('PASSWORD');
    $db = getenv('DATABASE');

    $con = mysqli_connect($server,$user,$pass,$db);


?>