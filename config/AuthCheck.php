<?php

if(!isset($_SESSION) || $_SESSION['authenticated'] != true) {
    http_response_code(401);
    die();
}

?>