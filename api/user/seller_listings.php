<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User object
    $user = new User($db);

    // Use session to verify User is logged in
    session_start();
    if (isset($_SESSION['userID'])) {
    // Show User listings (only if role == seller)
    $query =     
    }
    else {
        echo "Please login";
        // Redirect to login page
        $loginURL = 'http://' . $_SERVER['HTTP_HOST'] .
        dirname($_SERVER['PHP_SELF']) . '/login.php';
        header('Location: ' . $loginURL);
    }