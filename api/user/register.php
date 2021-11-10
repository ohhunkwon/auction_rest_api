<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing user object
    $user = new User($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $user->userID = $data->userID;
    $user->email = $data->email;
    $user->pwhash = $data->pwhash;
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->role = $data->role;
    $user->createdAt = $data->createdAt;
    $user->updatedAt = $data->updatedAt;
    $user->confirmPW = $data->confirmPW;

    if (empty($user->userID) ||
        empty($user->pwhash) ||
        empty($user->email) ||
        empty($user->firstName) ||
        empty($user->lastName) ||
        empty($user->role) ||
        empty($user->createdAt) ||
        empty($user->updatedAt)) {
        echo json_encode(
            array('message' => 'Please fill in all fields!')
        );
    } elseif ($user->pwhash !== $data->confirmPW) {
        echo json_encode(
            array('message' => 'Password and confirmed Password do not Match!')
        );
    } else {
        // Create listing user
        if ($user->register_user()) {
            echo json_encode(
                array('message' => 'User Created')
            );
        } else {
            echo json_encode(
                array('message' => 'User Not Created')
            );
        }
    }