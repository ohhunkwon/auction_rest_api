<?php
    include('../../config/AuthCheck.php');
    session_start();
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Bids.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $bid = new Bids($db);

    // Get itemID from URL
    //$bid->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
    $bid->userID = intval($_SESSION['userID']);

    // Get Bids, User, Items
    $result = $bid->read_bids();
    //Get row count
    $num = $result->rowCount();

    // Check if any items in listing
    if ($num == 0) {
        echo json_encode(
            array('message' => 'No Bids Found')
        );
        die();
    }

    // Bids array
    $bid_arr = array();
    $bid_arr['data'] = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Push to "data"
        array_push($bid_arr['data'], $row);
    }
    echo json_encode(
        $bid_arr
    );