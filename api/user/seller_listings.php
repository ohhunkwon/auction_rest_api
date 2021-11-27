<?php
    session_start();
    // Headers
    include('../../config/Cors.php');
    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User object
    $user = new User($db);

    // Get itemID from URL
    $user->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
    
    // Get users, User, Items
    $result = $user->read_listings_by_seller();
    //Get row count
    $num = $result->rowCount();

    // Check if any items in listing
    if ($num == 0) {
        echo json_encode(
            array()
        );
        die();
    }

    // users array
    $items_arr = array();
    $items_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Push to "data"
        array_push($items_arr['data'], $row);
    }

    echo json_encode(
        $items_arr
    );
