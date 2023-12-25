<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (
        !empty($data['username']) &&
        !empty($data['password']) &&
        !empty($data['email'])
    ) {
        $query = 'INSERT INTO users (username, password, email) VALUES (?,?,?)';

        $stmt = $conn->prepare($query);

        $stmt->bind_param('sss', $data['username'], $data['password'], $data['email']);

        $stmt->execute();

        if ($stmt) {
            echo json_encode(['message' => 'user inserted successfully']);
        } else {
            echo json_encode(['message' => 'Failed to insert the user']);
        }

        $stmt->close();
    } else {
        echo json_encode(['message' => 'Required fields (username, password, email) are missing or empty']);
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>