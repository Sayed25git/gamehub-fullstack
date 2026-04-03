<?php

$host = "localhost";
$username = "2435297";
$password = "deyasmaHian1325@";
$database = "db2435297";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>