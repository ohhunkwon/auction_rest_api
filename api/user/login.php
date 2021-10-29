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
        die('Please fill in all required fields!');
        }

    // Verify login

    $query = "SELECT userID, username FROM User " . WHERE user.username = '$username' AND " . "pw = SHA('$pw')";
    $data = mysqli_query($conn, $query);
    if (mysqli_num_rows($data) == 1) {
        $row = mysqli_fetch_array($data);
        setcookie('userID', $row['userID']);
        setcookie('username',$row['username']);
        $indexURL = 'http://' . $_SERVER['HTTP_HOST'] .
        dirname($_SERVER['PHP_SELF']) . '/index.php';
        header('Location: ' . $indexURL);
    } else {
        echo 'Invalid email or password.';
    }
