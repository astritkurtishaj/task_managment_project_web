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

    if (!isUserLoggedIn()) {
        echo json_encode([
            'success' => false,
            'message' => 'User must be logged in'
        ]);
        die();
    }

$title = $_POST['title'];
$description = trim($_POST['description']);
$status = trim($_POST['status']);
$userId = $_SESSION['id_user'];



$task = [
    'title' => $title,
    'description' => $description,
    'status' => $status
];

echo "<pre>";
var_dump($task);
die();



if(!empty($title) && !empty($description) && !empty($status)){
    storeTaskToFile($task, $userId);
}

// if (isUserLoggedIn()) {
//     header("Location: /social-network-db/timeline.php");
//     die();
// }


?>