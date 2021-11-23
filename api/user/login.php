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
    $data = json_decode(file_get_contents("php://input"));

    $user->userID = $data->userID;

    // Check fields not empty

    if (empty($data->userID) ||
        empty($data->inputpw)) {
        echo json_encode(
                array('message' => 'Please fill in userID and password!') 
        );
    }

    // Get user from db
    $result = $user->user_login();

    //Get row count
    $num = $result->rowCount();

    // Check if any user in Users
    if ($num > 0) {
        // Users array
        $users_arr = array();
        $users_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $user_instance = array(
                'userID' => $userID,
                'pwhash' => $pwhash
            );

            // Push to "data"
            array_push($users_arr['data'], $user_instance);
        }
        
        if (password_verify($data->inputpw, $users_arr['data'][0]['pwhash'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userID'] = $user->userID;
            echo json_encode(
                    array('message' => 'Welcome! Login successful!')
            );
        } else {
            echo json_encode(
                array('message' => 'Incorrect password!')
            );
        } 
    } else {
        echo json_encode(
            array('message' => 'Login failed')
        );
    } 
    

