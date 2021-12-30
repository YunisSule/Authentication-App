<?php

// URL: http://localhost/auth/user/getuserdata.php
session_start();
 require "../include/headers.php";
 require "../include/functions.php";

 $db = dbConnection();
 $username = $_SESSION["user"];

 try {
     $sql = "SELECT * FROM user_data WHERE username= :username";
     $prepared = $db->prepare($sql);
     $prepared->bindValue(':username', $username,PDO::PARAM_STR);
     $prepared->execute();

     $result = $prepared->fetch();
     echo json_encode($result);

 } catch(PDOException $e){
    echo $e->getMessage();
 }