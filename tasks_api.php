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

    if (!isUserLoggedIn()) {
        echo json_encode([
            'success' => false,
            'message' => 'User is not logged in'
        ]);
        die();
    }

    $userId = $_SESSION['id_user'];

  
    
    $userTasks = getUserTasks($userId);

    echo json_encode([
        'success' => true,
        'message' => 'tasks list',
        'data' => $userTasks

    ]);
?>