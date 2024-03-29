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
    if (isset($_GET['status'])) {
        $filterByStatus = $_GET['status'];
    }

    // Listing items query
    $result = $item->read();
    
    //Get row count
    $num = $result->rowCount();

    $items_arr = array();
    $items_arr['data'] = array();

    // Check if any items in listing
    if ($num == 0) {
        echo json_encode($items_arr);
        die();
    } 

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        if (isset($_GET['status']) && 
            ($filterByStatus == 'active' && $auctionStatus == 'inactive') || 
            ($filterByStatus == 'inactive' && $auctionStatus == 'active') ||
            ($auctionStatus === null)) {
            continue;
        }

        $item_instance = array(
            'itemID' => $itemID,
            'title' => $title,
            'description' => html_entity_decode($description),
            'category' => $category,
            'userID' => $userID,
            'seller' => $firstName,
            'startDateTime' => $startDateTime,
            'endDateTime' => $endDateTime,
            'startingPrice' => $startingPrice,
            'reservePrice' => $reservePrice,
            'latestBidID' => $bidID,
            'image' => $image,
            'auctionStatus' => $auctionStatus,
            'winner' => $winner
        );

        // Push to "data"
        array_push($items_arr['data'], $item_instance);
    }

    // Turn to JSON & output
    echo json_encode($items_arr);
