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
    $items = new Item($db);

    // Get userID from URL
    $userID = isset($_GET['userID']) ? $_GET['userID'] : die();

    // Get itemIDs that user ID has bidded on
    $result = $items->get_all_bidded_items($userID);

    // Item IDs array
    $itemIDs_arr = array();

    //Get row count
    $num = $result->rowCount();

    // Check if any item IDs associated

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Push to "data"
        array_push($itemIDs_arr, $itemID);
    }

    // Items array
    $items_arr = array();
    $items_arr['data'] = array();
    $set_itemIDs = array();

    // Check if any items
    foreach ($itemIDs_arr as $item) {

        $result = $items->read_recommendations($item, $userID, $db);
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            // && $itemToAdd["auctionStatus"] !== "inactive"
            if ($row && !in_array( $itemID,$set_itemIDs) && !in_array( $itemID,$itemIDs_arr)) {
                array_push($items_arr['data'], $row);
                array_push($set_itemIDs, $itemID);
            }
        }
    }

    // Turn to JSON & output
    echo json_encode($items_arr);