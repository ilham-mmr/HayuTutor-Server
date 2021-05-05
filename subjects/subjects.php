<?php
include_once("../dbconnect.php");

$stmt = $conn->prepare("SELECT * FROM subjects");
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $response["subjects"] = array();
    while ($row = $result->fetch_assoc()) {
        $subjectlist['title'] = $row['title'];
        $subjectlist['image'] = 'https://luxfortis.studio/app/images/subjects/' . $row['image'];
        array_push($response['subjects'], $subjectlist);
    }
    sendJsonResponse($response);
}

// function for sending json
function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
