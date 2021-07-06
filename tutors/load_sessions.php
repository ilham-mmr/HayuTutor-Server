<?php
include_once("../dbconnect.php");

$searchKeyword = $_GET['keyword'];

$stmt = $conn->prepare(
    "SELECT users.id, users.full_name, users.picture,  sessions.session_id, sessions.subject, sessions.duration, sessions.price, sessions.date, sessions.time, sessions.location FROM users INNER JOIN sessions ON users.id = sessions.tutor_id WHERE sessions.isBooked != 1 AND ( sessions.subject LIKE concat( '%', ?, '%') OR users.full_name LIKE concat( '%', ?, '%'))"
);
$stmt->bind_param('ss', $searchKeyword, $searchKeyword);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $sessions["sessions"] = array();
    while ($row = $result->fetch_assoc()) {
        $sessionList['tutorId'] = $row['id'];
        $sessionList['fullName'] = $row['full_name'];
        $sessionList['sessionId'] = $row['session_id'];
        $sessionList['subject'] = $row['subject'];
        $sessionList['duration'] = $row['duration'];
        $sessionList['price'] = $row['price'];
        $sessionList['date'] = $row['date'];
        $sessionList['time'] = $row['time'];
        $sessionList['location'] = $row['location'];
        $sessionList['picture'] = 'https://luxfortis.studio/app/images/profile_pictures/' . $row['picture'];
        array_push($sessions["sessions"], $sessionList);
    }
    $response = array('status' => 'success', 'data' => $sessions);
    http_response_code(200);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    http_response_code(404);
    sendJsonResponse($response);
}

// function for sending json
function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
