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

    // Get search input from URL
    $items->input = isset($_GET['input']) ? $_GET['input'] : die();

    // Get search result Item(s)
    $result = $items->read_search();

    //Get row count
    $num = $result->rowCount();

    // Check if any items in listing
    if ($num > 0) {
        // Items array
        $items_arr = array();
        $items_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $item_instance = array(
                'itemID' => $itemID,
                'title' => $title,
                'description' => html_entity_decode($description),
                'category' => $category,
                'userID' => $userID,
                'startDateTime' => $startDateTime,
                'endDateTime' => $endDateTime,
                'startingPrice' => $startingPrice,
                'reservePrice' => $reservePrice,
                'latestBidID' => $bidID,
                'image' => $image,
                'search_input' => $input
            );

            // Push to "data"
            array_push($items_arr['data'], $item_instance);
        }

        // Turn to JSON & output
        echo json_encode($items_arr);

    } else {
        echo json_encode(
            array('message' => 'No Items Found Matching Search query')
        );
    }