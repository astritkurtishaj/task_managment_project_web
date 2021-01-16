<?php
session_start();
require_once "util.php";

// if logged in then redirect to timeline.php
if (isUserLoggedIn()) {
    header("Location: /task_managment_project_web/timeline.php");
    die();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
    <div style="position: absolute; top: 15vh" class="row container-fluid justify-content-center ">
        <form class="col-3 " id="register_form">
            <div class="mb-3 mt-7">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control success" id="full_name" aria-describedby="fullNameHelp">
            </div>
            <div class="mb-3 mt-7">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control error" name="email" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="button" class="btn btn-primary" id="btnRegister">Register</button><br><br>
            <small id="message"></small>
            <a href="/task_managment_project_web/index.php">Click here to login</a>
        </form>
    </div>
</body>

<script>  
    $(document).ready(function () {
        $('#btnRegister').click(function (e) {
                e.preventDefault();
                const fullName = $("#full_name").val().trim();
                const email = $("#email").val().trim();
                const password = $("#password").val().trim();
                const apiEndpoint = "http://localhost/task_managment_project_web/register_logic.php";
                if(checkPassword(password) != true){
                    var message = 'Password is wrong, must contain 6-20 charachters, letters (one must be capital), symbols and numbers';
                    alert(message);
                }   
                else{
                    $.post(apiEndpoint, {
                    'full_name': fullName,
                    'email': email,
                    'password': password
                    }, function(response){
                    if(response.success == false){
                        alert(response.message);
                    }else{
                        $("#full_name").val("");
                        $("#email").val("");
                        $("#password").val("");
                        $("small").text("You successfully Registered click below to login!").css("color", "green"); 
                    }
                    });
                    return false;
                }
        })           
    });

    function checkPassword(password) { 
        var passwordTemplate = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
        if(password.match(passwordTemplate)) { 
            return true;
        }
        else{ 
            return false;
        }
    }
   
    </script>
</html>