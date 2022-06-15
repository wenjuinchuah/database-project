<?php
    $servername = 'localhost';
    $username = 'root';
    $password = 'Root@123';
    $dbname = 'blooddonation';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    global $conn;

    // Check connection
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error($conn));
    }
?>