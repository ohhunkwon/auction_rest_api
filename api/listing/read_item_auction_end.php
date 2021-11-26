<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Item.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $item = new Item($db);

    // Get itemID from URL
    $item->itemID = isset($_GET['itemID']) ? $_GET['itemID'] : die();

    // Get Item
    $result = $item->read_item_auction_end();
    
    //Get row count
    $num = $result->rowCount();

    if ($num == 0) {
        echo json_encode(
            array('winner' => "No Winner")
        );
    }

    // Check if any items in listing
    if ($num > 0) {

        // Items array
        $items_arr = array();
        $items_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $item_instance = array(
                'userID' => $userID,
                'highestPrice' => $highestPrice,
                'reservePrice' => $reservePrice,
                'title' => $title,
                'description' => $description,
                'category' => $category,
                'bidID' => $bidID,
                'endDateTime' => $endDateTime,
                'startDateTime' => $startDateTime
            );

            // Push to "data"
            array_push($items_arr['data'], $item_instance);
        }

        // Check if reservePrice has been met
        if ($items_arr['data'][0]['highestPrice'] >= $items_arr['data'][0]['reservePrice']) {
            echo json_encode(
                $items_arr
            );
        } else {
            header("HTTP/1.1 400 'Reserve price not met!'");
        }
    }