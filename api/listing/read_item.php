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

    // Get Category Item(s)
    $result = $item->read_item();
    
    //Get row count
    $num = $result->rowCount();

    $data_arr = array();
    $data_arr['item'] = array();
    $data_arr['winner'] = array();

    // Check if any items in listing
    if ($num == 0) {
        echo json_encode($data_arr);
        die();
    }

    ///////////////     CHECK IF AUCTION HAS ENDED SECTION:

    // Get Category Item(s)
    $sql_query = $item->has_auction_ended();

    $result_endtime = $sql_query->fetch(PDO::FETCH_ASSOC);
    $end_datetime = new Datetime($result_endtime["endDateTime"]);

    $now = new DateTime();

    $user_select = $item->read_user_latest_bid();

    $result_1 = $user_select->fetch(PDO::FETCH_ASSOC);
    $item->userID = $result_1["userID"] ?? '';
    $item->firstName = $result_1["firstName"] ?? '';
    $item->lastName = $result_1["lastName"] ?? '';

    // Set auctionStatus and set Winner only if auction has ended
    if ($now > $end_datetime) {
        $item->set_status_inactive_set_winner();
        
        $user_instance = array(
            'userID' => $item->userID,
            'firstName' => $item->firstName,
            'lastName' => $item->lastName,
        );

        // Push to "data"
        array_push($data_arr['winner'], $user_instance);
    }

    ///////////////     RETURN ITEM

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

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
            'image' => $image
        );

        // Push to "data"
        array_push($data_arr['item'], $item_instance);
    }

    // Turn to JSON & output
    echo json_encode($data_arr);
