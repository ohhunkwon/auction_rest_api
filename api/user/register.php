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

    if (empty($user->userID) ||
        empty($user->pwhash) ||
        empty($user->email) ||
        empty($user->firstName) ||
        empty($user->lastName) ||
        empty($user->role)) {
        echo json_encode(
            array('message' => 'Please fill in all fields!')
        );
        die();
    } 
    if ($user->pwhash !== $data->confirmPW) {
        echo json_encode(
            array('message' => "Passwords don't match!")
        );
    }
    
    else {
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

    
    /*
    if ($data['pw'] !== $data['pwconfirm']) {
        die("Password and confirm passwords fields do not match!");
    }
    */