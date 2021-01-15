<?php
session_start();

    require_once "util.php";
    header('Content-Type: application/json');

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        echo json_encode([
            'success' => false,
            'message' => 'POST Method HTTP required'
        ]);
    }
    $id_task = $_POST['id_task'];
    $new_status = $_POST['status'];
    
    if(isset($_POST['id_task']) && isset($_POST['status'])){
        updateTask($new_status, $id_task);
    }

    // echo "<pre>";
    // var_dump($changed_status);
    // die();
    echo json_encode([]);

?>