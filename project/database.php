<?php 

    $hostname = 'MySQL-8.4';
    $dbname = 'cardsdb';
    $dbusername = 'root';
    $dbpassword = '';
    
    try{

        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8",$dbusername,$dbpassword);
        echo "Db connected!";

    }catch(Exception $e){

        echo 'Db is not connected! '.$e->getMessage();

    }


    
    





?>