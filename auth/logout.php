<?php
require "../include/headers.php";

// URL: http://localhost/auth/auth/logout.php

session_start();
try {
    session_unset();
    session_destroy();

    echo '{"logged" : false}';
    header('Content-Type: application/json');
} catch(PDOException $e){
    echo $e->getMessage();
}





