<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Bids.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $bid = new Bids($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $bid->itemID = $data->itemID;
    $bid->createdAt = $data->createdAt;
    $bid->amount = $data->amount;
    $bid->bidID = $data->bidID;
    $bid->userID = $data->userID;

// Get highest bid for item before we try to insert new bid
$result = $bid->get_highest_bid($bid->itemID);
    
//Get row count
$num = $result->rowCount();

// Check if any result from getHighestBid helper function
if ($num > 0) {
    // Items array
    $bid_arr = array();
    $bid_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $bid_instance = array(
            'highestPrice' => $highestPrice
        );
        // Push to "data"
        array_push($bid_arr['data'], $bid_instance);
    }

    if ($bid_arr['data'][0]['highestPrice'] < $bid->amount) {
        // Run insert query if price of bid is valid
        if ($bid->create()) {
            echo json_encode(
                array('message' => 'Bid Created')
            );
        } else {
            echo json_encode(
                array('message' => 'Bid Not Created')
            );
        }
    } else {
        echo json_encode(
            array('message' => 'Bid amount is too Low!')
        );
    }

} else {
    echo json_encode(
        array('message' => 'No highestPrice Found')
    );
}