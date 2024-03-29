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
    include_once '../../models/Item.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Listing Item object
    $item = new Item($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to delete
    $item->itemID = $data->itemID;

    // Delete listing item
    if ($item->delete()) {
        echo json_encode(
            array('message' => 'Listing Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Listing Not Deleted')
        );
    }
