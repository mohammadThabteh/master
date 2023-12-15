<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (!isset($data)) {
        // Handle invalid or missing JSON data
        $response = array("success" => false, "message" => "Invalid or missing JSON data");
        echo json_encode($response);
        exit;
    }

    // Extract data from JSON
    // $order_id = isset($data['order_id']) ? $data['order_id'] : null;
    $order_price = isset($data['order_price']) ? $data['order_price'] : null;
    $description = isset($data['description']) ? $data['description'] : "";

    // Validate required fields
    // if ($order_id === null || $order_price === null) {
    //     $response = array("success" => false, "message" => "Missing required field: order_id or order_price");
    //     echo json_encode($response);
    //     exit;

    // Perform database update using the existing connection from include.php
    $update_query = "UPDATE booking SET order_price = ?, description = ? WHERE order_id = 1";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ds", $order_price, $description);

    if ($stmt->execute()) {
        $response = array("success" => true, "message" => "Booking updated successfully");
    } else {
        $response = array("success" => false, "message" => "Error updating booking: " . $stmt->error);
    }

    $stmt->close();

    echo json_encode($response);
}
?>
