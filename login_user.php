<?php

include_once("dbconnect.php");

$email = $_POST['email'];
$password = $_POST['password'];
$array = array();



if (!isset($_POST)) {
    $array['status'] = 'failed';
    $array['user'] = null;
    sendJsonResponse($array);
    die();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp = '0'");
$stmt->bind_param("s",  $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


if (password_verify($password, $row['password'])) {

    $array['status'] = 'success';
    $array['user'] = array('full_name' => $row['full_name'], 'email' => $row['email'], 'registration_date' => $row['registration_date']);
    sendJsonResponse($array);
} else {
    $array['status'] = 'failed';
    $array['user'] = null;
    sendJsonResponse($array);
}

$stmt->close();
$conn->close();

// function for sending json
function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
