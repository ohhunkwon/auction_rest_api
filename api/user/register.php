<?php
    // Headers
    include('../../config/Cors.php');
    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing user object
    $user = new User($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $user->email = $data->email;
    $user->pwhash = $data->password;
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->role = $data->role;
    $user->createdAt = $data->createdAt;
    $user->updatedAt = $data->updatedAt;

    if (
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

    if ($data->password !== $data->confirmPassword) {
        // throw back a 400 bad request response ---> DONE!
        http_response_code(400);
        die();
    } else {
        // Create listing user
        if ($user->register_user()) {
            // this IF is probably redundant - it will always create a user until you hit an error, in which case everything breaks
            echo json_encode(array('message' => 'User Created'));
        } else {
            echo json_encode(array('message' => 'User Not Created'));
        }
    }