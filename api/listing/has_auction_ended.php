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

    // Check if any items in listing
    return $now > $end_datetime ? true : false;
    