<?php
    session_set_cookie_params(0, '/', '.vercel.app');
    session_start();
    // Headers
    include_once '../../config/Cors.php';
    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User object
    $user = new User($db);
    // Validation of data entry
    $data = json_decode(file_get_contents("php://input"));

    $user->email = $data->email;
    // Check fields not empty
    if (empty($data->email) || empty($data->password)) {
        echo json_encode(
                array('message' => 'Please fill in email and password!') 
        );
        die();
    }

    // Get user from db
    $result = $user->user_login();
    if ($result->rowCount() == 0) {
        http_response_code(400);
        echo json_encode(
            array('message' => 'User/Email not found')
        );
        die();
    }
    
    // Check if any user in Users
    $userResult = $result->fetch(PDO::FETCH_ASSOC);
    if (password_verify($data->password, $userResult['pwhash'])) {
        $_SESSION['authenticated'] = true;
        $_SESSION['userID'] = $userResult['userID'];
        unset($userResult['pwhash']);
        echo json_encode($userResult);
    } else {
        http_response_code(401);
        echo json_encode(
            array('message' => 'Incorrect password!')
        );
        die();
    }
