<?php
include_once("../dbconnect.php");

if (!isset($_POST['userId'])) {
  echo 'failed';
  die();
}
$userId = $_POST['userId'];
$subject = $_POST['subject'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$price = $_POST['price'];
$date = $_POST['date'];
$time = $_POST['time'];

$stmt = $conn->prepare("INSERT INTO sessions (session_id, subject, duration, price, date, time, location, tutor_id) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sddsssi', $subject, $duration, $price, $date, $time, $location, $userId);

if ($stmt->execute()) {
  http_response_code(200);
  echo 'success';
} else {
  http_response_code(500);
  echo 'failed';
}
