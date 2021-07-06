<?php
include_once("../dbconnect.php");

if (!isset($_POST['userId'])) {
    echo 'failed';
    die();
}
$sessionId = $_POST['sessionId'];
$userId = $_POST['userId'];
$subject = $_POST['subject'];
$duration = $_POST['duration'];
$location = $_POST['location'];
$price = $_POST['price'];
$date = $_POST['date'];
$time = $_POST['time'];

$stmt = $conn->prepare("UPDATE sessions SET subject=?, duration=?, price=?, date=?, time=?, location=? WHERE tutor_id=? AND session_id=?");
$stmt->bind_param('sddsssii', $subject, $duration, $price, $date, $time, $location, $userId, $sessionId);

if ($stmt->execute()) {
    http_response_code(200);
    echo 'success';
} else {
    http_response_code(500);
    echo 'failed';
}
