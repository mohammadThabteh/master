<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request data
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate the required fields
    if (isset($data['user_id'], $data['id'])) {
        $user_id = $data['user_id'];
        $id = $data['id'];

        // Construct the SQL query and execute
        $query = "SELECT * FROM animal WHERE user_id = $user_id AND id = $id";

        // Log the SQL query for debugging
        error_log("SQL Query: $query");

        // Check database connection in the include.php file
        if (!$conn) {
            $response = ['success' => false, 'message' => 'Database connection error'];
        } else {
            // Execute the query and check for errors
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Fetch the pet details
                $pet = mysqli_fetch_assoc($result);

                if ($pet) {
                    $response = ['success' => true, 'pet' => $pet];
                } else {
                    $response = ['success' => false, 'message' => 'Pet not found'];
                }
            } else {
                // Log the database error for debugging
                $response = ['success' => false, 'message' => 'Error fetching pet details: ' . mysqli_error($conn)];
                error_log("Database Error: " . mysqli_error($conn));
            }
        }
    } else {
        $response = ['success' => false, 'message' => 'user_id and id are required fields'];
    }

    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method. Use POST.']);
}
