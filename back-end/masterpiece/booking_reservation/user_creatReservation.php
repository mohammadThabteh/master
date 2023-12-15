<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

// API endpoint to add an animal to animal_booking and calculate total price
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve JSON data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if the required fields are present in the JSON data
    if (isset($data['animal_id'], $data['user_id'], $data['start_date'], $data['end_date'])) {
        $animal_id = $data['animal_id'];
        $user_id = $data['user_id'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        // Fetch one-day price from the booking table
        $booking_price_query = "SELECT order_price FROM booking WHERE order_id = 1"; // Assuming order_id 1 is for one-day price
        $booking_price_result = $conn->query($booking_price_query);

        if ($booking_price_result->num_rows > 0) {
            $row = $booking_price_result->fetch_assoc();
            $one_day_price = $row['order_price'];

            // Calculate the difference between start and end dates to get the number of days
            $datetime1 = new DateTime($start_date);
            $datetime2 = new DateTime($end_date);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

            // Calculate total price
            $total_price = $one_day_price * $days;

            // Insert data into animal_booking table
            $insert_query = "INSERT INTO animal_booking (animal_id, booking_id, start_date, end_date, total_price, status)
                             VALUES ($animal_id, 1, '$start_date', '$end_date', $total_price, 'pending')"; // Assuming booking_id 1 is for one-day booking

            if ($conn->query($insert_query) === TRUE) {
                echo json_encode(["success" => true, "message" => "Animal added to booking successfully. Total price: $" . $total_price]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . $insert_query . "<br>" . $conn->error]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "No one-day price found in the booking table"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Missing required fields in the JSON data"]);
    }
}

$conn->close();
?>
