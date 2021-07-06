<?php
include_once("../dbconnect.php");

$stmt = $conn->prepare("SELECT users.id, users.full_name, users.picture, sessions.price, sessions.subject, sessions.location FROM users INNER JOIN sessions ON users.id = sessions.tutor_id GROUP BY users.id ");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response["tutors"] = array();
    while ($row = $result->fetch_assoc()) {
        $tutorList['tutorId'] = $row['id'];
        $tutorList['full_name'] = $row['full_name'];
        $tutorList['picture'] = 'https://luxfortis.studio/app/images/profile_pictures/' . $row['picture'];
        $tutorList['location'] = $row['location'];
        $tutorList['price'] = $row['price'];
        $tutorList['subject'] = $row['subject'];


        array_push($response['tutors'], $tutorList);
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
