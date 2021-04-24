<?php
include_once("load_env.php");

$servername = $_ENV['SERVER_NAME'];

$username   = $_ENV['DB_USER'];

$password   = $_ENV['DB_PASSWORD'];

$dbname     = $_ENV['DB_NAME'];



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}
