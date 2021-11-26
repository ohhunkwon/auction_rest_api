<?php
    include('../../config/AuthCheck.php');
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

    // Use session to verify User is logged in
    if (isset($_SESSION['userID'])) {
    // Show User listings (only if role == seller)
    // $query =  
        $user->userID = intval($_SESSION['userID']); 
    } else {
        // don't redirect - just throw back a 401 unauthorized ---> DONE!
        http_response_code(401);

        // echo "Please login";
        // Redirect to login page
        // $loginURL = 'http://' . $_SERVER['HTTP_HOST'] .
        // dirname($_SERVER['PHP_SELF']) . '/login.php';
        // header('Location: ' . $loginURL);
    }


    // Get itemID from URL
    //$user->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
    

    // Get users, User, Items
    $result = $user->read_listings_by_seller();
    //Get row count
    $num = $result->rowCount();

    // Check if any items in listing
    if ($num == 0) {
        echo json_encode(
            array('message' => 'No listings found')
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
