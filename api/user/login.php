<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User object
    $user = new User($db);

    // Validation of data entry
    //$data = $_POST;
    $data = json_decode(file_get_contents("php://input"));

    $user->userID = $data->userID;

    // Check fields not empty

    if (empty($data->userID) ||
        empty($data->inputpw)) {
        echo json_encode(
                array('message' => 'Please fill in all required fields!') 
        );
    }

    /* // Redirect to login page (is this necessary/is there a better way?)

    $loginURL = 'http://' . $_SERVER['HTTP_HOST'] .
    dirname($_SERVER['PHP_SELF']) . '/login.php';
    header('Location: ' . $loginURL); */
    
    // Get user from db
    $result = $user->select_user();

    // Get row count
    $num = $result->rowCount();

    // Check if user exists in database
    if ($num == 1) {
        if (password_verify($data->inputpw, $user->pwhash)) {
            echo json_encode(
                    array('message' => 'Login successful!')
            );
        } else {
            echo json_encode(
                array('message' => 'Login failed')
            );
        }  
    }




    