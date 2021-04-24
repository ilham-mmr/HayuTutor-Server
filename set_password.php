<?php
include_once("dbconnect.php");
include_once("emailer.php");
if (!isset($_POST)) {
    echo 'failed';
    die();
}
$email = $_POST['email'];
$otp_forgotPW = $_POST['otp'];
$password = $_POST['password'];
$passhash = password_hash($password, PASSWORD_DEFAULT);


$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ? AND otp_forgotPW = ?");
$stmt->bind_param("ssi", $passhash,  $email, $otp_forgotPW);
$stmt->execute();
$stmt->store_result();
$affectedRow = $stmt->affected_rows;
if ($affectedRow > 0) {
    $stmt = $conn->prepare("UPDATE users SET otp_forgotPW = 0 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    echo 'success';
} else {
    echo 'failed';
}


$stmt->close();
$conn->close();
