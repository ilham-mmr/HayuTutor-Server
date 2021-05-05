<?php
include_once("../dbconnect.php");

$stmt = $conn->prepare("SELECT users.full_name, users.picture, user_tutor.location, sessions.price FROM users INNER JOIN user_tutor ON users.id = user_tutor.user_id INNER JOIN sessions ON user_tutor.tutor_id = sessions.tutor_id LIMIT 0, 3");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response["tutors"] = array();
    while ($row = $result->fetch_assoc()) {
        $tutorList['full_name'] = $row['full_name'];
        $tutorList['picture'] = 'https://luxfortis.studio/app/images/profile_pictures/'.$row['picture'];
        $tutorList['location'] = $row['location'];
        $tutorList['price'] = $row['price'];

        array_push($response['tutors'], $tutorList);
    }
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
