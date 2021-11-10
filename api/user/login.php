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

    // Validation of data entry
    $data = $_POST;

    if (empty($data['username']) ||
        empty($data['pw']) || {
        echo 'Please fill in all required fields!';
        // Redirect to login page (is this necessary/is there a better way?)
        $loginURL = 'http://' . $_SERVER['HTTP_HOST'] .
        dirname($_SERVER['PHP_SELF']) . '/login.php';
        header('Location: ' . $loginURL);
        }

    // Verify login, start session and redirect to index.php

    $query = "SELECT userID, username FROM User " . "WHERE user.username = '$username' AND " . "pw = SHA('$pw')";
    $data = mysqli_query($conn, $query);
    if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['username'] = $row['username'];
        $indexURL = 'http://' . $_SERVER['HTTP_HOST'] .
        dirname($_SERVER['PHP_SELF']) . '/index.php';
        header('Location: ' . $indexURL);
    } else {
        echo 'Invalid email or password.';
        // Redirect to login page
        $loginURL = 'http://' . $_SERVER['HTTP_HOST'] .
        dirname($_SERVER['PHP_SELF']) . '/login.php';
        header('Location: ' . $loginURL);
    }