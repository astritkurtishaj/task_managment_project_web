<?php

    require_once 'db.php';

    function isUserLoggedIn(){
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    function doesUserExistByEmail($email){
        global $dbConnection;
        $sqlQuery = "SELECT * FROM `users` WHERE email = :email";
        
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":email", $email);
    
        if($statement->execute()){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user !== false){
            return true;
            }
        }else{
            return false;
        }
    
    }

    function findUserByEmailAndPassword($email, $password){
        global $dbConnection;
    
        $sqlQuery = "SELECT * FROM users WHERE email = :email AND password = :password";
        
        $encryptedPassword = md5($password);
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $encryptedPassword);

        if($statement->execute()){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user != false){
                return $user;
            }
        }
        return null;
    }
     

    

    function storeUserToFile(array $user){
       global $dbConnection;
        $sqlQuery = " INSERT INTO `users` (`full_name`, `email`, `password`)
        VALUES (:fullName, :email, :password); ";

        $encryptedPassword = md5($user['password']);
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":fullName", $user['full_name']);
        $statement->bindParam(":email", $user['email']);
        $statement->bindParam(":password", $encryptedPassword);
        
        if($statement->execute()){
            return true;
        }else{
            echo "Wrong!"; 
            die();
            return false;
        }
    }


    function signOut(){
        session_start();
        session_destroy();
    }

    //function to store posts in file

    function storeTaskToFile(array $task, $userId){
        global $dbConnection;
        $sqlQuery = " INSERT INTO `tasks` (`title`,`description`, `id_user`)
        VALUES (:title, :description, :userId); ";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":title", $task['title']);
        $statement->bindParam(":description", $task['description']);
        $statement->bindParam(":userId", $userId);

        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }


    function getUserTasks($userId) {
        global $dbConnection;

        $sqlQuery = "SELECT * FROM tasks WHERE id_user = :userId order by created_at DESC";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":userId", $userId);
        
        if($statement->execute()){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            return [];
        }
        
    }

    function deletePostByIdAndUser($postId, $userId){
        global $dbConnection;

        $sqlQuery = "DELETE FROM `posts` WHERE `id_post`=:id_post AND `id_user`=:id_user;";

        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":id_post", $postId);
        $statement->bindParam(":id_user", $userId);

        if($statement->execute()){
            return true;
        }else{
            return false;
        }

    }

    function updateTask($taskId, $userId, $title, $description){
        global $dbConnection;
        
        $sqlQuery = "UPDATE `tasks` SET `title`=:title, `description`=:description WHERE `id_task`=:id_task AND `id_user`=:id_user;";

        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":id_task", $taskId);
        $statement->bindParam(":id_user", $userId);

        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    function getPostByIdAndUser($postId, $userId){
        global $dbConnection;
        $sqlQuery = "SELECT * FROM posts WHERE id_post=:id_post AND id_user=:id_user";

        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(':id_post', $postId);
        $statement->bindParam(':id_user', $userId);

        if($statement->execute()){
            $post = $statement->fetch(PDO::FETCH_ASSOC);
            if($post !== false){
                return $post;
            }
        }
        return null;
    }
?>