<?php
    include('../../config/AuthCheck.php');
    // session must start before headers
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

    // Close session
    if (isset($_SESSION['userID'])) {
        $_SESSION = array();
        session_destroy();
    }