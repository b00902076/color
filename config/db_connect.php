<?php
    $servername = "localhost";
    $username = "root";
    $password = "ppp";
    $dbname = "huang";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Set charset, or data
    $conn->set_charset("utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
