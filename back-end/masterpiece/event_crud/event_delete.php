<?php
/////////////////////////////////////////////////////////////////////////////
///////////////////use Delete Method  ///////////////////////////////////////
/////////////////send the event_id /////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  $json_data = file_get_contents('php://input');
  $data = json_decode($json_data, true);
  if (!empty($data)) {
    $event_id=$data['event_id'];

    $query = "DELETE FROM events WHERE event_id =  $event_id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(['message' => 'Event deleted successfully']);
    } else {
        echo json_encode(['message' => 'Failed to delete the event']);
    }
} else {
    echo json_encode(['message' => 'No data provided ']);
}
} else {
echo json_encode(['message' => 'Incorrect request method']);
}

