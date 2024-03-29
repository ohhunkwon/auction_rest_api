<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS, DELETE');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        // The request is using the POST method
        header("HTTP/1.1 200 OK");
        return;
    }
    include_once '../../config/Database.php';
    include_once '../../models/WatchList.php';

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
