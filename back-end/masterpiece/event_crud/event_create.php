<?php
/////////////////////////////////////////////////////////////////////////////
///////////////////use POST Method  ///////////////////////////////////////// 
/////////////////send the event image,start /////////////////////////////////
/////////////////description, max_guests,category,end////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (!empty($data)) {
        $event_start = mysqli_real_escape_string($conn, $data['event_start']);
        $event_image = mysqli_real_escape_string($conn, $data['event_image']);
        $event_description = $data['event_description']; 
        $event_max_guests = intval($data['event_max_guests']);
        $event_category = mysqli_real_escape_string($conn, $data['event_category']);
        $event_end = mysqli_real_escape_string($conn, $data['event_end']);

        $query = "INSERT INTO events (event_start, event_image, event_description, event_max_guests, event_category, event_end) VALUES ('$event_start', '$event_image', '$event_description', $event_max_guests, '$event_category', '$event_end')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo json_encode(['message' => 'Event inserted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to insert the event']);
        }
    } else {
        echo json_encode(['message' => 'No data provided for insertion']);
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}

