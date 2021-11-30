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
    $sql_query = $item->has_auction_ended();

    $result = $sql_query->fetch(PDO::FETCH_ASSOC);
    $end_datetime = new Datetime($result["endDateTime"]);

    $now = new DateTime();

    $user_select = $item->read_user_latest_bid();

    $result_1 = $user_select->fetch(PDO::FETCH_ASSOC);
    $item->userID = $result_1["userID"];
    $item->firstName = $result_1["firstName"];
    $item->lastName = $result_1["lastName"];

    // Set auctionStatus and set Winner only if auction has ended
    if ($now > $end_datetime) {
        $item->set_status_inactive_set_winner();
        
        $user_arr = array();
        $user_arr['data'] = array();

        $user_instance = array(
            'userID' => $item->userID,
            'firstName' => $item->firstName,
            'lastName' => $item->lastName,
        );

        // Push to "data"
        array_push($user_arr['data'], $user_instance);

        echo json_encode(
            $user_arr
        );
        
    } else {
        die();
    }

    // return $now > $end_datetime ? true : false;
    