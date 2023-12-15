<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $json_data = file_get_contents('php://input');
  $data = json_decode($json_data, true);

  if (!isset($data)) {
    $response = array("success" => false, "message" => "Invalid or missing JSON data");
    echo json_encode($response);
    exit;
  }

  $order_price = isset($data['order_price']) ? $data['order_price'] : null;
  $description = isset($data['description']) ? $data['description'] : "";

  if ($order_price === null) {
    $response = array("success" => false, "message" => "Missing required field: order_price");
    echo json_encode($response);
    exit;
  }

  $insert_query = "INSERT INTO booking (order_price, description) VALUES (?, ?)";
  $stmt = $conn->prepare($insert_query);
  $stmt->bind_param("ds", $order_price, $description);

  if ($stmt->execute()) {
    $response = array("success" => true, "message" => "Booking created successfully");
  } else {
    $response = array("success" => false, "message" => "Error creating booking: " . $stmt->error);
  }

  $stmt->close();

  echo json_encode($response);
}
