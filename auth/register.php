<?php
 require "../include/headers.php";
 require "../include/functions.php";

// URL: http://localhost/auth/auth/register.php

$db = dbConnection();
    $body = json_decode(file_get_contents('php://input'));
    $username = filter_var($body->username, FILTER_SANITIZE_STRING);
    $password = password_hash(filter_var($body->password, FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
    $fname = filter_var($body->firstname, FILTER_SANITIZE_STRING);
    $lname = filter_var($body->lastname, FILTER_SANITIZE_STRING);
    $email = filter_var($body->email, FILTER_SANITIZE_STRING);
    $address = filter_var($body->address, FILTER_SANITIZE_STRING);
    $city = filter_var($body->city, FILTER_SANITIZE_STRING);
    $zip = filter_var($body->zip, FILTER_SANITIZE_STRING);

    $isUser = checkIfUser($db, $username, $email);
try{
        
    if (!$isUser) {
         $sql = "INSERT IGNORE INTO users VALUES (:username, :password); 
            INSERT IGNORE INTO user_data VALUES (:username, :fname, :lname, :email, :address, :city, :zip);"; 

        $prepared = $db->prepare($sql);
        $prepared->bindValue(':fname', $fname,PDO::PARAM_STR);
        $prepared->bindValue(':lname', $lname,PDO::PARAM_STR);
        $prepared->bindValue(':email', $email,PDO::PARAM_STR);
        $prepared->bindValue(':address', $address,PDO::PARAM_STR);
        $prepared->bindValue(':city', $city,PDO::PARAM_STR);
        $prepared->bindValue(':zip', $zip,PDO::PARAM_STR);
        $prepared->bindValue(':username', $username,PDO::PARAM_STR);  
        $prepared->bindValue(':password', $password,PDO::PARAM_STR); 
        $prepared->execute();

        

        echo '{"info": "User registered", "status" : "ok"}';
        header('Content-Type: application/json');
        header('HTTP/1.1. 200 OK');
       

    }
} catch(PDOException $e){
    echo $e->getMessage(); 
}

    
