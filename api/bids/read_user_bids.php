<?php
    // include('../../config/AuthCheck.php');
    // session_start();
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
    $bid->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
    // $bid->userID = intval($_SESSION['userID']);

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
    $bid_arr['bids'] = array();
    $bid_arr['user'] = array();
    $bid_arr['items'] = array();
    $all_bid_IDs = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Push to "data"
        array_push($bid_arr['bids'], $row);
        array_push($all_bid_IDs, $itemID);
    }


    $result_user = $bid->read_user();

    while ($row = $result_user->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Push to "data"
        array_push($bid_arr['user'], $row);
        unset($bid_arr['user'][0]['pwhash']);
    }

    foreach ($all_bid_IDs as &$value) {
        $bid->itemID = $value;
        $result_items = $bid->read_items();

        while ($row = $result_items->fetch(PDO::FETCH_ASSOC)) {
    
            extract($row);
    
            // Push to "data"
            array_push($bid_arr['items'], $row);
        }
    }

    echo json_encode(
        $bid_arr
    );

    