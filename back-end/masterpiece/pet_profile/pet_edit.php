<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  // Get the JSON data from the request body
  $json_data = file_get_contents("php://input");

  // Decode the JSON data
  $pet_data = json_decode($json_data, true);

  // Validate the required fields
  if (isset($pet_data['user_id'], $pet_data['id'])) {
    // Extract data
    $image = isset($pet_data['image']) ? "'" . $pet_data['image'] . "'" : 'NULL';
    $name = "'" . $pet_data['name'] . "'";
    $user_id = (int) $pet_data['user_id'];
    $id = $pet_data['id'];
    $age = isset($pet_data['age']) ? "'" . $pet_data['age'] . "'" : 'NULL';

    // Construct the SQL query and execute
    $query = "UPDATE animal SET image = $image, age = $age, name = $name WHERE user_id = $user_id AND id = $id";

    // Log the SQL query for debugging
    error_log("SQL Query: $query");

    // Check database connection
    if (!$conn) {
      $response = ['success' => false, 'message' => 'Database connection error'];
    } else {
      // Execute the query and check for errors
      if (mysqli_query($conn, $query)) {
        $response = ['success' => true, 'message' => 'Pet details updated successfully'];
      } else {
        // Log the database error for debugging
        $response = ['success' => false, 'message' => 'Error updating pet details: ' . mysqli_error($conn)];
        error_log("Database Error: " . mysqli_error($conn));
      }
    }
  } else {
    $response = ['success' => false, 'message' => 'user_id and id are required fields'];
  }

  echo json_encode($response);
} else {
  echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
