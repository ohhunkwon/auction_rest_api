<?php
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
            array('message' => 'User/Email not fouund')
        );
        die();
    }
    
    session_set_cookie_params(time() + 34000, '/', getenv('ORIGIN_URL'), false, true);
    session_start();
    // Check if any user in Users
    $userResult = $result->fetch(PDO::FETCH_ASSOC);
    if (password_verify($data->password, $userResult['pwhash'])) {
        $_SESSION['authenticated'] = true;
        $_SESSION['userID'] = $userResult['userID'];
        unset($userResult['pwhash']);
        echo json_encode($userResult);
    } else {
        echo json_encode(
            array('message' => 'Incorrect password!')
        );
        die();
    }
