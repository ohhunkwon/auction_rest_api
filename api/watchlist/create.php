<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Watchlist.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Watchlist item object
    $watchlist = new Watchlist($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $check_duplicate = $watchlist->check_unique_item($data->itemID, $data->userID);

    if ($check_duplicate->rowCount() == 1) {
        http_response_code(400);
        die();
    }

    $watchlist->itemID = $data->itemID;
    $watchlist->userID = $data->userID;

    // Create listing item
    if ($watchlist->create()) {
        echo json_encode(
            array('message' => 'Watchlist Item Added')
        );
    } else {
        echo json_encode(
            array('message' => 'Watchlist Item Not Added')
        );
    }