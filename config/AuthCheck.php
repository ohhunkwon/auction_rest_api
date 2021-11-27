<?php
    include('../../config/Cors.php');

    if(!isset($_COOKIE["PHPSESSID"])) {
        http_response_code(401);
        die();
    }
?>