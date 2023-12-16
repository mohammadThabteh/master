<?php
// API=localhost/masterpiece\event_crud\deleteEventAttend.php
// use the delete method
// send user_id and event_id

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

// Assuming you receive JSON data in the request body
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  
  try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    // Check if required parameters are present in the JSON data
    if (isset($data['user_id']) && isset($data['event_id'])) {
      $user_id = $data['user_id'];
      $event_id = $data['event_id'];

      // Delete user registration from the event
      $sql = "DELETE FROM user_events WHERE user_id = '$user_id' AND event_id = '$event_id'";

      if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "User registration deleted from the event successfully"));
      } else {
        echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
      }
    } else {
      echo json_encode(array("status" => "error", "message" => "Invalid or missing parameters"));
    }

    // Close the connection
    $conn->close();
  } catch (Exception $e) {
    echo json_encode(array("status" => "error", "message" => "An error occurred: " . $e->getMessage()));
  }
} else {
  echo json_encode(array("status" => "error", "message" => "Method not allowed"));
}

