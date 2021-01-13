<?php
    require_once "util.php";
    signOut();
    echo json_encode([
        'success' =>true,
        'message' => "User session is done"
    ]);
    die();
?>