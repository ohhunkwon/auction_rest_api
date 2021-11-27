<?php
    // session must start before headers
    session_start();
    // Headers
    include('../../config/Cors.php');
    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Close session

        $_SESSION = array();
        session_destroy();
