<?php
    include('../../config/AuthCheck.php');
    session_start();
    // Headers
    include('../../config/Cors.php');
    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User object
    $user = new User($db);

    // Use session to verify User is logged in
    if (isset($_SESSION['userID'])) {
    // Show User listings (only if role == seller)
    // $query =  
        return;   
    } else {
        // don't redirect - just throw back a 401 unauthorized ---> DONE!
        http_response_code(401);

        // echo "Please login";
        // Redirect to login page
        // $loginURL = 'http://' . $_SERVER['HTTP_HOST'] .
        // dirname($_SERVER['PHP_SELF']) . '/login.php';
        // header('Location: ' . $loginURL);
    }