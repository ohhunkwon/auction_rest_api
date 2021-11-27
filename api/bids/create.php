<?php
    session_start();
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
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
    $bid->userID = $data->userID;

    // Check if user creating bid is Buyer, not Seller
    $res = $bid->get_user_role($data->userID);

    $role = $res->fetch(PDO::FETCH_ASSOC)["role"];

    if ($role === "Seller") {
        http_response_code(401);
        die();
    }

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
                    array(
                        "itemID" => $bid->itemID,
                        "createdAt" => $bid->createdAt,
                        "amount" => $bid->amount,
                        "userID" => $bid->userID,
                    )
                );
                $bid->update_highest_price($bid->itemID, $bid->bidID, $bid->amount);
                $result = $bid->read_latest_bidID_itemID();
                $BIDID = $result->fetch(PDO::FETCH_ASSOC)["bidID"];
                $bid->set_bidID_items_table($BIDID, $bid->itemID);
            } else {
                echo json_encode(
                    array()
                );
            }
        } else {
            http_response_code(400);
        }

    } else {
        http_response_code(401);
    }