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
    $email = $_POST['email'];
    $password= $_POST['password'];

    $user = findUserByEmailAndPassword($email, $password);

    if($user != null){
        // logged in
        $_SESSION['logged_in'] = true;
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $email;
        $_SESSION['id_user'] = $user['id_user'];
        echo json_encode([
            'success' => true,
            'message' => 'Authenticated'
        ]);
        die();
    }else {
        
        $_SESSION['logged_in'] = false;
        echo json_encode([
            'success' => false,
            'message' => 'Wrong credentials!!'
        ]);
    }


?>