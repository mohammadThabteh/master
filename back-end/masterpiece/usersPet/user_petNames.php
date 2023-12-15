<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
//////////////////////////////////////use the Get methode////////////////////////////////////// 
///////////////////////////////////////send the user_id///////////////////////////////////////
/////////you will use it in the droplest to show the names of the pet the user have//////////

include '../include.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if the required parameter 'user_id' is present in the JSON data
    
    if (isset($data['user_id'])) {
        $user_id = $data['user_id'];

        // Use the user_id directly in the SQL query
        $sql = "SELECT name , id as animal_id FROM animal WHERE user_id = $user_id";
        $result = $conn->query($sql);

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            $pets = array();
            // Fetch rows and add them to the $pets array
            while ($row = $result->fetch_assoc()) {
                $pets[] = $row;
            }
            // Encode $pets array to JSON and echo it
            echo json_encode($pets);
        } else {
            // No records found
            echo json_encode(array("message" => "No pet records found for the provided user ID."));
        }
    } else {
        // 'user_id' not provided
        echo json_encode(array("error" => "Please provide the user_id in the request."));
    }
} else {
    // Invalid request method
    echo json_encode(array("error" => "Invalid request method. Only POST requests are allowed."));
}

// Close the database connection
$conn->close();

