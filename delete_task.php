<?php
session_start();

    require_once "util.php";
    header('Content-Type: application/json');

    if($_SERVER['REQUEST_METHOD'] !== 'GET'){
        echo json_encode([
            'success' => false,
            'message' => 'GET Method HTTP required'
        ]);

    }

    deleteTaskById($taskId);



?>