<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  $json_data = file_get_contents('php://input');
  $data = json_decode($json_data, true);

  if (!empty($data)) {
    $id = $data['id'];
    $query = 'DELETE FROM users WHERE id = ?';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    $affected_rows = $stmt->affected_rows;

    if ($affected_rows > 0) {
      echo json_encode(array("message" => "User deleted successfully."));
    } else {
      echo json_encode(array("error" => "Error: " . $conn->error));
    }

    $stmt->close();
  } else {
    echo json_encode(array("message" => "No data provided for deletion."));
  }
} else {
  echo json_encode(array("error" => "Invalid request method. Please use the DELETE method."));
}
?>
