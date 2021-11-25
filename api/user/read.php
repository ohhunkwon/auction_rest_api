<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $user = new User($db);

    // Get itemID from URL
    $user->userID = isset($_GET['userID']) ? $_GET['userID'] : die();

    // Listing items query
    $result = $user->read_user();

    //Get row count
    $num = $result->rowCount();

    if ($result->rowCount() == 0) {
        echo json_encode(
            array('message' => 'No User Found')
        );
        die();
    }

    // Items array
    $users_arr = array();
    $users_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_instance = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'role' => $role,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt
        );

        // Push to "data"
        array_push($users_arr['data'], $user_instance);
    }

    // Turn to JSON & output
    echo json_encode($users_arr);
