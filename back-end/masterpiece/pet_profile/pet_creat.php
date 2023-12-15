<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the JSON data from the request body
  $json_data = file_get_contents("php://input");

  // Decode the JSON data
  $pet_data = json_decode($json_data, true);

  // Validate the required fields
  if (isset($pet_data['user_id'])) {
    // Extract data
    $image = isset($pet_data['image']) ? "'" . $pet_data['image'] . "'" : 'NULL';
    $name = "'" . $pet_data['name'] . "'";
    $user_id = (int) $pet_data['user_id'];
    $age = isset($pet_data['age']) ? "'" . $pet_data['age'] . "'" : 'NULL';

    // Construct the SQL query and execute
    $query = "INSERT INTO `animal` (`image`, `name`, `user_id`, `age`) VALUES ($image, $name, $user_id, $age)";

    if (mysqli_query($conn, $query)) {
      $response = ['success' => true, 'message' => 'Pet details inserted successfully'];
    } else {
      $response = ['success' => false, 'message' => 'Error inserting pet details: ' . mysqli_error($conn)];
    }
  } else {
    $response = ['success' => false, 'message' => 'Name and user_id are required fields'];
  }

  echo json_encode($response);
} else {

  echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
