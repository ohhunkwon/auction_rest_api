<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/WatchList.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $watchlist = new Watchlist($db);

    // Get userID from URL
    $watchlist->userID = isset($_GET['userID']) ? $_GET['userID'] : die();

    // Get Category Item(s)
    $result = $watchlist->read();

    //Get row count
    $num = $result->rowCount();

    // Items array
    $watchlist_arr = array();
    $watchlist_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $watchlist_instance = array(
            'itemID' => $itemID,
            'title' => $title,
            'userID' => $userID,
            'startDateTime' => $startDateTime,
            'reservePrice' => $reservePrice,
            'description' => $description,
            'category' => $category,
            'endDateTime' => $endDateTime,
            'startingPrice' => $startingPrice,
            'bidID' => $bidID,
            'image' => $image
        );

        // Push to "data"
        array_push($watchlist_arr['data'], $watchlist_instance);
    }

    // Turn to JSON & output
    echo json_encode($watchlist_arr);

