<?php

    $dsn  = "mysql:host=localhost; dbname=upload_image";

    $user = "root";

    $pass = "";

    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    );

    try {

        $conn = new PDO($dsn, $user, $pass, $options);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {

        echo "Faild connection !" . $e->getMessage();

    }