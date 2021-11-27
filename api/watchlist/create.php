<?php
    session_start();
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
    include_once '../../config/Database.php';
    include_once '../../models/Watchlist.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Watchlist item object
    $watchlist = new Watchlist($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

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