<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "../include.php";

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    $userId = $data['id'];
    $image = $data['image'] ?? '';
    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $setClauses = [];
    if (!empty($username)) {
        $setClauses[] = "username = '$username'";
    }
    if (!empty($image)) {
        $setClauses[] = "image = '$image'";
    }
    if (!empty($email)) {
        $setClauses[] = "email = '$email'";
    }
    if (!empty($password)) {
        $setClauses[] = "password = '$password'";
    }

    if (!empty($setClauses)) {
        $update_profile_query = "UPDATE users SET " . implode(", ", $setClauses) . " WHERE id = $userId";
        $result = mysqli_query($conn, $update_profile_query);

        if ($result === false) {
            $response = array(
                'error' => 'Failed to update profile.',
                'sql_error' => mysqli_error($conn)
            );
        } else {
            $response = array(
                'success' => 'Profile updated successfully.'
            );
        }
    } else {
        $response = array(
            'error' => 'No values provided for update.'
        );
    }

    echo json_encode($response);
} else {
    $response = array(
        'error' => 'Please use a PUT request.'
    );
    echo json_encode($response);
}

mysqli_close($conn);


// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// include "include.php";

// if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
//     $json_data = file_get_contents('php://input');
//     $data = json_decode($json_data, true);

//     $userId = $data['id'];

    // // Fetch the existing user data
    // $fetch_user_query = "SELECT * FROM users WHERE id = $userId";
    // $existingUserData = mysqli_query($conn, $fetch_user_query)->fetch_assoc();

    // if (!$existingUserData) {
    //     $response = array(
    //         'error' => 'User not found.'
    //     );
    //     echo json_encode($response);
    //     mysqli_close($conn);
    //     exit;
    // }

    // $setClauses = array();

    // if (isset($data['image']) && $data['image'] !== $existingUserData['image']) {
    //     $setClauses[] = "image = '" . $data['image'] . "'";
    // }
    // if (isset($data['username']) && $data['username'] !== $existingUserData['username']) {
    //     $setClauses[] = "username = '" . $data['username'] . "'";
    // }
    // if (isset($data['email']) && $data['email'] !== $existingUserData['email']) {
    //     $setClauses[] = "email = '" . $data['email'] . "'";
    // }
    // if (isset($data['password']) && $data['password'] !== $existingUserData['password']) {
    //     $setClauses[] = "password = '" . $data['password'] . "'";
    // }

    // if (!empty($setClauses)) {
    //     $update_profile_query = "UPDATE users SET " . implode(", ", $setClauses) . " WHERE id = $userId";

    //     $result = mysqli_query($conn, $update_profile_query);

//         if ($result === false) {
//             $response = array(
//                 'error' => 'Failed to update profile.',
//                 'sql_error' => mysqli_error($conn)
//             );
//         } else {
//             $response = array(
//                 'success' => 'Profile updated successfully.'
//             );
//         }
//     } else {
//         $response = array(
//             'success' => 'No changes made to the profile.'
//         );
//     }

//     echo json_encode($response);
// } else {
//     $response = array(
//         'error' => 'Please use a PUT request.'
//     );
//     echo json_encode($response);
// }

// mysqli_close($conn);
