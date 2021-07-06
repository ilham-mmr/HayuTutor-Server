<?php
include_once("../dbconnect.php");

$userId = $_GET['userId'];
$sessionId = $_GET['sessionId'];

$stmt = $conn->prepare("DELETE FROM sessions WHERE session_id =? AND tutor_id=?");
$stmt->bind_param('ii', $sessionId, $userId);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    http_response_code(200);
    echo 'success';
} else {
    http_response_code(404);
    echo 'failed';
}
