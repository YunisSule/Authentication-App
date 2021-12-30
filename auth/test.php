<?php
session_start();

// URL: http://localhost/auth/auth/test.php

if(isset($_SESSION["user"])){

    echo '{"logged" : true}';
    header('Content-Type: application/json');
    exit;
}

echo '{"logged" : false}';
header('Content-Type: application/json');