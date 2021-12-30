<?php

function dbConnection(){

    try{
        $db = new PDO('mysql:host=localhost;dbname=k0suyu00', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo $e->getMessage();    
    }

    return $db;
}

function login(PDO $db, $username, $passwd){


    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $passwd = filter_var($passwd, FILTER_SANITIZE_STRING);

    try{
        $sql = "SELECT * FROM users WHERE username= :username"; 
        $prepared = $db->prepare($sql);   
        $prepared->bindValue(':username', $username,PDO::PARAM_STR);
        $prepared->execute();  

        $rows = $prepared->fetchAll(); 
       
        foreach($rows as $row){
            $pw = $row["password"];
            if( password_verify($passwd, $pw) ){
                return true;
            }
        }
        return false;

    } catch(PDOException $e){
        echo json_encode($e->getMessage()); 
    }
}

function checkIfUser($db, $username, $email){
    try {
        $sql = 'SELECT * FROM user_data WHERE username = :username OR email = :email';
        $prepared = $db->prepare($sql);
        $prepared->bindValue(':username', $username,PDO::PARAM_STR);
        $prepared->bindValue(':email', $email,PDO::PARAM_STR);
        $prepared->execute();

        $rows = $prepared->fetchAll();

        if (!$rows) {
            return false;
        } else {
            foreach($rows as $row){
                $dbEmail = $row["email"];
                $dbUsername = $row["username"]; 

                if($dbEmail == $email ){  
                    echo '{"info": "This email address is already being used"}';
                    header('Content-Type: application/json');
                    header(("HTTP/1.1 500"));
                    exit;
                 } elseif ($dbUsername == $username) {
                    echo '{"info": "This username is already being used"}';
                    header('Content-Type: application/json');
                    header(("HTTP/1.1 500"));
                    exit;
                 }
             }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

