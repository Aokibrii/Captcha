<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SecuredLogin";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$connection->set_charset('utf8mb4');
