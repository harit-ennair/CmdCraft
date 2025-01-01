<?php
    $host = 'localhost';
    $dbname = 'command_craft';
    $username = 'root';
    $password = '';
           
    try {
        $conn = "mysql:host=".$host.";dbname=".$dbname;
        $pdo = new PDO($conn,$username,$password);
        

    } catch (PDOException $e) {
        
        echo "connection failed";

    }



    ?>

