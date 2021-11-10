<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Watchlist.php';

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

    // Check if any items in listing
    if ($num > 0) {
        // Items array
        $watchlist_arr = array();
        $watchlist_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $watchlist_instance = array(
                'itemID' => $itemID,
                'userID' => $userID
            );

            // Push to "data"
            array_push($watchlist_arr['data'], $watchlist_instance);
        }

        // Turn to JSON & output
        echo json_encode($watchlist_arr);

    } else {
        echo json_encode(
            array('message' => 'No Watchlist items Found')
        );
    }