<?php

include_once("dbconnect.php");
include_once("emailer.php");


$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = $_POST['password'];

$encoded_base64string = $_POST["encoded_base64string"];

if (!isset($_POST) || empty($full_name) || empty($email) || empty($password)) {
    echo 'failed';
    die();
}

// image base64 user profile
$filename = uniqid() . '.png';



$passhash = password_hash($password, PASSWORD_DEFAULT);


$otp = rand(1000, 9999);

$stmt = $conn->prepare("INSERT INTO users (id, full_name, email, password, otp, picture) VALUES (NULL, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssis", $full_name, $email, $passhash, $otp, $filename);


if ($stmt->execute()) {
    // image base64 user profile
    $decoded_string = base64_decode($encoded_base64string);
    $path = './images/profile_pictures/' . $filename;
    $is_written = file_put_contents($path, $decoded_string);


    $message = '<p>Dear user,</p>';
    $message .= '<p>Please click on the following link to verify your account.</p>';
    $message .= '<p>-------------------------------------------------------------</p>';
    $message .= "<p><a href='https://luxfortis.studio/app/verify_account.php?email=" . $email . "&key=" . $otp . "'>Click here to verify</a></p>";
    $message .= '<p>-------------------------------------------------------------</p>';
    $message .= '<p>Thanks,</p>';
    $message .= '<p>LuxFor Studio</p>';

    $subject = "Email Verification - LuxFor Studio";

    if (sendEmail($email, $message, $subject)) {
        echo "success";
    } else {
        echo "failed";
    }
} else {

    echo "failed";
}

$stmt->close();
$conn->close();
