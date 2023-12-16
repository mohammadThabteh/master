<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include "../include.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the JSON data contains the user_id
    if (isset($_GTE['user_id'])) {
        $user_id = $_GET['user_id'];

        // Fetch accepted animal_booking details along with user and animal details
        $animal_booking_query = "SELECT animal_booking.*, users.username AS user_name, animal.name AS animal_name
        FROM animal_booking
        INNER JOIN animal ON animal_booking.animal_id = animal.id
        INNER JOIN users ON animal.user_id = users.id
        WHERE animal_booking.status = 'accepted'
        AND animal.user_id = $user_id";

        $result = $conn->query($animal_booking_query);

        if ($result->num_rows > 0) {
            $animal_bookings = array();
            while ($row = $result->fetch_assoc()) {
                $animal_bookings[] = $row;
            }
            // Return JSON response with accepted animal_booking details
            echo json_encode($animal_bookings);
        } else {
            echo "No accepted animal bookings found for this user";
        }
    } else {
        echo "Invalid JSON data. Please provide a user_id.";
    }
}
?>