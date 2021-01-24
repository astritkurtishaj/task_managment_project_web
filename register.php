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
        <form onkeyup="validatedInputs();" class="col-3 " id="register_form" style="border: 1px solid gray; padding: 50px; border-radius: 15px;">
            <div class="mb-3 mt-7">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control name"  required id="full_name" placeholder="Your full name..." aria-describedby="fullNameHelp">
                <div id="name_message"></div>
            </div>
            <div class="mb-3 mt-7">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control email" required name="email" id="email" placeholder="example@example.com" aria-describedby="emailHelp">
                <div id="email_message"></div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control password" name="password" placeholder="Example*123" id="password">
                <div id="password_message"></div>
            </div>
            <button type="button" class="btn btn-primary" id="btnRegister">Register</button><br><br>
            <small id="message"></small><br>
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
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            const apiEndpoint = "http://localhost/task_managment_project_web/register_logic.php";
            
            if(validatedInputs() != true){
                return false;
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
                    $(".password").css("border-color", "#ced4da");
                    $("#password_message").text("");
                    $(".name").css("border-color", "#ced4da");
                    $(".email").css("border-color", "#ced4da");
                    $("small").text("You successfully Registered click below to login!").css("color", "green").css("font-weight", "bold"); 
                }
                });
                return false;
            }
    })           
});

function validatedInputs(){
    const fullName = $("#full_name").val().trim();
    const email = $("#email").val().trim();
    const inputedPassword = $("#password").val().trim();
    
        if(validateName(fullName) != true || validateEmail(email) != true || checkPassword(inputedPassword) != true)
            return false;
        else {
            return true;
        }
}
function validateName(name){
    if(name.length < 4){
        $(".name").css("border-color", "red");
        $("#name_message").text("Name is required!!").css("color", "red");
        return false;
    }
    else{
        $(".name").css("border-color", "green");
        $("#name_message").text("");
        return true;
    }

}
function validateEmail(email){
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if(email == "" || !email.match(emailPattern)){
        $(".email").css("border-color", "red");
        $("#email_message").text("Email is required!!").css("color", "red");
        return false;
    }
    else{
        $(".email").css("border-color", "green");
        $("#email_message").text("");
        return true;
    }

}

function checkPassword(password) { 
    var passwordTemplate = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    if(!password.match(passwordTemplate)) { 
        $(".password").css("border-color", "red");
        $("#password_message").text("Strong password is required!!").css("color", "red");
        return false;
    }
    else{ 
        $(".password").css("border-color", "green");
        $("#password_message").text("");
        return true;
       
    }
}
</script>
</html>