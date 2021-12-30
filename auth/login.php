<?php

// URL: http://localhost/auth/auth/login.php

session_start();
require "../include/headers.php";
require "../include/functions.php";
try {
    if( isset($_SERVER['PHP_AUTH_USER']) ){
    if(login(dbConnection(), $_SERVER['PHP_AUTH_USER'],$_SERVER["PHP_AUTH_PW"] )){
        $_SESSION["user"] = $_SERVER['PHP_AUTH_USER'];

        echo '{"info" : "Logged in" , "status" : "ok"}';
        header('Content-Type: application/json');
        header('HTTP/1.1. 200 OK');
        exit;
    }
}

echo '{"info":"Failed to login"}';
header('Content-Type: application/json');
header(("HTTP/1.1 401"));
exit;
} catch(PDOException $e){
    echo $e->getMessage();
}


   