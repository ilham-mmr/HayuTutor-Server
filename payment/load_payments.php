<?php
include_once("../dbconnect.php");

if (!isset($_GET['email'])) {
    http_response_code(400);
    echo 'failed';
}


$email = $_GET['email'];

$stmt = $conn->prepare("SELECT tbl_purchased.orderid,tbl_purchased.email,tbl_purchased.paid, tbl_purchased.status, 
            sessions.subject, users.email AS tutor_email, users.full_name AS tutor_name, sessions.date 
            FROM tbl_purchased JOIN sessions ON tbl_purchased.sessionId = sessions.session_id 
            JOIN users ON sessions.tutor_id = users.id WHERE tbl_purchased.email=?");
$stmt->bind_param('s', $email);

$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $response["payment"] = array();
    while ($row = $result->fetch_assoc()) {
        $paymentList['orderId'] = $row['orderid'];
        $paymentList['email'] = $row['email'];
        $paymentList['paid'] = $row['paid'];
        $paymentList['status'] = $row['status'];
        $paymentList['subject'] = $row['subject'];
        $paymentList['tutorEmail'] = $row['tutor_email'];
        $paymentList['tutorName'] = $row['tutor_name'];
        $paymentList['date'] = $row['date'];


        array_push($response['payment'], $paymentList);
    }
    http_response_code(200);
    sendJsonResponse($response);
} else {
    http_response_code(404);
    echo 'failed';
    return;
}

function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
