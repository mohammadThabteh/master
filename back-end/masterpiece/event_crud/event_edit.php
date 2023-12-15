<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

// Assuming the request is a POST request with JSON data
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {

        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Validate and sanitize input data as needed

        // Extract data
        $event_id = isset($data['event_id']) ? $data['event_id'] : null;
        $event_start = isset($data['event_start']) ? $data['event_start'] : null;
        $event_image = isset($data['event_image']) ? $data['event_image'] : null;
        $event_description = isset($data['event_description']) ? $data['event_description'] : null;
        $event_max_guests = isset($data['event_max_guests']) ? $data['event_max_guests'] : null;
        $event_category = isset($data['event_category']) ? $data['event_category'] : null;

        // Check if $conn is a valid MySQLi connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Check if event_id is set
        if ($event_id === null) {
            throw new Exception("Invalid request. Event ID is missing.");
        }

        // Update the event in the database
        $query = "UPDATE events SET 
            event_start = '" . $conn->real_escape_string($event_start) . "',
            event_image = '" . $conn->real_escape_string($event_image) . "',
            event_description = '" . $conn->real_escape_string($event_description) . "',
            event_max_guests = '" . $conn->real_escape_string($event_max_guests) . "',
            event_category = '" . $conn->real_escape_string($event_category) . "'
            WHERE event_id = $event_id";

        $result = $conn->query($query);

        if ($result) {
            // Return success response
            echo json_encode(array("message" => "Event updated successfully"));
        } else {
            // Return error response
            http_response_code(500);
            echo json_encode(array("message" => "Unable to update event. " . $conn->error));
        }
    } catch (Exception $e) {
        // Return error response
        http_response_code(500);
        echo json_encode(array("message" => "Unable to update event. " . $e->getMessage()));
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Return error response for unsupported request
    http_response_code(400);
    echo json_encode(array("message" => "Bad request"));
}
?>
<!-- {
    "event_id": 2,
    "event_start": "2023-11-25 12:00:00",
    "event_image": "image_url.jpg",
    "event_description": "Event description",
    "event_max_guests": 50,
    "event_category": "Category"

} -->