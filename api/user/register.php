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

    // Instantiate User object
    $user = new User($db);

    // Validation of data entry
    $data = $_POST;

    if (empty($data['email']) ||
        empty($data['pw']) ||
        empty($data['pwconfirm']) ||
        empty($data['firstName']) ||
        empty($data['lastName']) ||
        empty($data['role'])) {
        die('Please fill in all required fields!');
        }

    if ($data['pw'] !== $data['pwconfirm']) {
        die("Password and confirm passwords fields do not match!")
    }

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $user->userID = $data->userID;
    $user->pwhash = password_hash($data->pw, PASSWORD_DEFAULT);
    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->email = $data->email;
    $user->role = $data->role;
    $user->createdAt = $data->createdAt;
    $user->updatedAt = $data->updatedAt;

        // Create User
        if ($user->register()) {
            echo json_encode(
                array('message' => 'User Created')
            );
        } else {
            echo json_encode(
                array('message' => 'User Not Created')
            );
        }