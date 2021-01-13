<?php
// connection parameters
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "task_management";

    //create connection

    $dbConnection = null;
    try{
        $dbConnection = new PDO('mysql:host='.$host.';dbname='.$dbName, 
        $user, $password);
        }catch(Exeption $e){
            echo "Connection failed: ".$e->getMessage();
            die();

    }

    if(!$dbConnection){
        echo "No database connection";
        die();
    }

?>