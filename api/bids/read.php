<?php
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
    $bid->itemID = isset($_GET['itemID']) ? $_GET['itemID'] : die();

    // Get Category Item(s)
    $result = $bid->read_latest_bid();
    
    //Get row count
    $num = $result->rowCount();

    // Check if any items in listing
    if ($num > 0) {
        // Items array
        $bid_arr = array();
        $bid_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $bid_instance = array(
                'itemID' => $itemID,
                'latestBidID' => $bidID,
                'createdAt' => $createdAt,
                'userID' => $userID,
                'priceOfLatestBid' => $amount
            );
            // Push to "data"
            array_push($bid_arr['data'], $bid_instance);
        }

        // Turn to JSON & output
        echo json_encode($bid_arr);

    } else {
        echo json_encode(
            array('message' => 'No Bids Found')
        );
    }