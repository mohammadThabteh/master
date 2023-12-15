<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

// Assuming you receive JSON data in the request body
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if required parameters are present in the JSON data
    if (isset($data['user_id'])) {
      $user_id = $data['user_id'];

      // Retrieve events for the specified user
      $sql = "SELECT events.event_image, events.event_start, events.event_description FROM user_events 
              INNER JOIN events ON user_events.event_id = events.event_id
              WHERE user_events.user_id = '$user_id'";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $events = array();
        while ($row = $result->fetch_assoc()) {
          $events[] = array(
            "event_image" => $row["event_image"],
            "event_start" => $row["event_start"],
            "event_description" => $row["event_description"]
          );
        }
        echo json_encode(array("status" => "success", "events" => $events));
      } else {
        echo json_encode(array("status" => "success", "message" => "No events found for the user"));
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

