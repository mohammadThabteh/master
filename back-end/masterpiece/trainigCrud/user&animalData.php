

<!-- بدي اعدل عليه -->

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Include the file with the database connection
include "../include.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['user_id'])) {
            $user_id = $data['user_id'];
    
            $query = "SELECT tb.*, a.name AS animal_name, t.name AS training_name
                      FROM training_booking tb
                      INNER JOIN animal a ON tb.animal_id = a.id
                      INNER JOIN training t ON tb.training_id = t.training_id
                      WHERE a.user_id = $user_id";
    
            $result = $conn->query($query);
    
            $bookings = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $booking = array(
                        "booking_id" => $row['booking_id'],
                        "animal_name" => $row['animal_name'],
                        "training_name" => $row['training_name'],
                        "training_date" => $row['training_date'],
                        "training_end_date" => $row['training_end_date'],
                        "price" => $row['price'],
                        "description" => $row['description']
                    );
                    $bookings[] = $booking;
                }
                echo json_encode($bookings);
            } else {
                echo "No bookings found for this user";
            }
        } else {
            echo "User ID not provided";
        }
    }
    
    $conn->close();

// API endpoint to fetch bookings for a specific user
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);

//     if (isset($data['user_id'])) {
//         $user_id = $data['user_id'];

//         $query = "SELECT tb.*, a.name AS animal_name, t.name AS training_name
//                   FROM training_booking tb
//                   INNER JOIN animal a ON tb.animal_id = a.id
//                   INNER JOIN training t ON tb.training_id = t.training_id
//                   WHERE a.user_id = $user_id";

//         $result = $conn->query($query);

//         $bookings = array();
//         if ($result->num_rows > 0) {
//             while ($row = $result->fetch_assoc()) {
//                 $booking = array(
//                     "booking_id" => $row['booking_id'],
//                     "animal_name" => $row['animal_name'],
//                     "training_name" => $row['training_name'],
//                     "training_date" => $row['training_date'],
//                     "training_end_date" => $row['training_end_date'],
//                     "price" => $row['price'],
//                     "description" => $row['description']
//                 );
//                 $bookings[] = $booking;
//             }
//             echo json_encode($bookings);
//         } else {
//             echo "No bookings found for this user";
//         }
//     } else {
//         echo "User ID not provided";
//     }
// }

// $conn->close();
// ?>