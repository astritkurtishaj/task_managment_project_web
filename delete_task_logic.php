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

    $id_user = $_SESSION['id_user'];
    $id_task = $_POST['id_task'];

    if(isset($_POST['id_task']) && isset($_POST['id_user'])){
        deleteTaskById($id_task, $id_user);
    }

    echo json_encode([]);

?>