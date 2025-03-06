<?php
    $server_name = "localhost";
    $db_name = "ml_system";
    $db_username = "root";
    $db_password = "";


    $conn = new mysqli($server_name,$db_username,$db_password);

    if($conn ->connect_error){
        die("Database connection failed. " . $conn->connect_error);
    }else{
        echo "Database Connection Succesful.";
    }


?>