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
    $id_user = $_SESSION['id_user'];
    
    if(isset($_POST['id_task']) && isset($_POST['status']) && isset($_POST['id_user'])){
        updateTask($new_status, $id_task, $id_user);
    }

    // echo "<pre>";
    // var_dump($changed_status);
    // die();
    echo json_encode([]);

?>