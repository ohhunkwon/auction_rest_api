<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Watchlist.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $watchlist = new Watchlist($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to delete
    $watchlist->itemID = $data->itemID;
    $watchlist->userID = $data->userID;

    // Delete listing item
    if ($watchlist->delete()) {
        echo json_encode(
            array('message' => 'Watchlist Item Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Watchlist Item Not Deleted')
        );
    }
