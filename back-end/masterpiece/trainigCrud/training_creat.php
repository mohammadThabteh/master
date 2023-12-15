<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include your database connection or any other necessary files
include '../include.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get JSON data from the request body
  $json_data = file_get_contents('php://input');
  $data = json_decode($json_data, true);

  // Check if JSON data is successfully decoded
  if ($data === null) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid JSON data."));
    exit();
  }

  // Check if required fields are present in the JSON data
  if (empty($data['name']) || empty($data['description']) || empty($data['image']) || empty($data['price'])) {
    http_response_code(400);
    echo json_encode(array("message" => "Missing required fields."));
    exit();
  }

  // Sanitize input data
  $name = $conn->real_escape_string($data['name']);
  $description = $conn->real_escape_string($data['description']);
  $image = $conn->real_escape_string($data['image']);
  $price = floatval($data['price']);

  // Insert into the training table
  $sql = "INSERT INTO training (name, description, image, price) VALUES ('$name', '$description', '$image', $price)";

  if ($conn->query($sql) === TRUE) {
    http_response_code(201);
    echo json_encode(array("message" => "Training created successfully."));
  } else {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating training: " . $conn->error));
  }
} else {
  http_response_code(405);
  echo json_encode(array("message" => "Method Not Allowed."));
}
