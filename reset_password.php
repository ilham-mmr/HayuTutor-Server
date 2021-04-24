<?php
include_once("dbconnect.php");
include_once("emailer.php");

$email = $_POST['email'];
$array = array();

if (!isset($_POST) || empty($email)) {
    $array['status'] = 'failed';
    $array['data'] = null;

    sendJsonResponse($array);
    die();
}

// check if the email exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp = '0'");
$stmt->bind_param("s",  $email);
$stmt->execute();
$stmt->store_result();
$affectedRow = $stmt->num_rows;

if ($affectedRow > 0) {
    $otp_forgotPW = rand(1000, 9999);
    $stmt = $conn->prepare("UPDATE users SET otp_forgotPW = ? WHERE email = ?");
    $stmt->bind_param("is",  $otp_forgotPW, $email);
    $stmt->execute();

    $message = '<p>Dear user,</p>';
    $message .= '<p>The following is the reset password code</p>';
    $message .= '<p>-------------------------------------------------------------</p>';
    $message .= "<p>" . $otp_forgotPW . "</p>";
    $message .= '<p>-------------------------------------------------------------</p>';
    $message .= '<p>Thanks,</p>';
    $message .= '<p>LuxFor Studio</p>';

    $subject = "Reset Password - LuxFor Studio";
    if (sendEmail($email, $message, $subject)) {
        $array['status'] = 'success';
        $array['data'] = array('email' => $email, 'otp' => $otp_forgotPW);
        sendJsonResponse($array);
    } else {
        $array['status'] = 'failed';
        $array['data'] = null;
        sendJsonResponse($array);
    }
} else {
    $array['status'] = 'failed';
    $array['data'] = null;

    sendJsonResponse($array);
}

function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

//generate hash
// store it in forgotPassword token
$stmt->close();
$conn->close();
