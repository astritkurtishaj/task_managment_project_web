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

    if (isUserLoggedIn()) {
        echo json_encode([
            'success' => false,
            'message' => 'User is already authenticated'
        ]);
        die();
    }

    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = [
        'full_name' => $fullName,
        'email' => $email,
        'password' => $password,
        'tasks' => []
    ];

    if (doesUserExistByEmail($email)) {
        echo "This user already exists!";
        die();
    }

    // save to file
    storeUserToFile($user);
?>