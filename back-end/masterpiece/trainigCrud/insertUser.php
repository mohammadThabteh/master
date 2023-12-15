<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the file with the database connection
include "../include.php";

// Assuming you receive JSON data in the request body
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  try {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Validate the input data (you may need more validation depending on your requirements)
    if (!isset($data['animal_id']) || !isset($data['training_id']) || !isset($data['description'])) {
      http_response_code(400);
      echo json_encode(array("message" => "Incomplete data. Please provide animal_id, training_id, and description."));
      exit();
    }

    $animal_id = $data['animal_id'];
    $training_id = $data['training_id'];
    $description = $data['description'];

    // Interpolate values into the SQL query with a JOIN statement
    $query = "INSERT INTO `training_booking` (`animal_id`, `training_id`, `training_date`, `training_end_date`, `price`, `description`) 
              SELECT 
                $animal_id, 
                $training_id, 
                NOW(), 
                DATE_ADD(NOW(), INTERVAL 30 DAY), 
                training.`price`, 
                '$description'
              FROM 
                `training`
              WHERE 
                `training`.`training_id` = $training_id";

    $result = mysqli_query($conn, $query);

    if ($result) {
      http_response_code(201);
      echo json_encode(array("message" => "Animal linked to training successfully."));
    } else {
      http_response_code(500);
      echo json_encode(array("message" => "Error linking animal to training: " . mysqli_error($conn)));
    }
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Internal Server Error: " . $e->getMessage()));
  }
} else {
  http_response_code(405);
  echo json_encode(array("message" => "Method Not Allowed"));
}
