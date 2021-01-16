<?php
    session_start();
    require_once "util.php";
    
    // if logged in then redirect to timeline.php
    if(isUserLoggedIn()){
        header("Location: /task_managment_project_web/timeline.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>
    <div style="position: absolute; top: 15vh" class="row container-fluid justify-content-center ">
        <form onsubmit="return login();" class="col-3 "  style="border: 1px solid gray; padding: 40px; border-radius: 15px;">
            <div class="mb-3 mt-7">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="example@example.com" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="**********" id="password">
            </div>  
            <button type="submit" class="btn btn-primary">Log in</button><br><br>
            <a href="/task_managment_project_web/register.php">Click here to register</a>
        </form>
    </div>

</body>

<script>
    function login(){
      const email = $("#email").val();
      const password = $("#password").val();
        const apiEndpoint = "http://localhost/task_managment_project_web/login_logic.php";
        $.post(apiEndpoint, {
            'email': email,
            'password': password
        }, function(response){
            console.log(response);
            if(response.success == false){
                alert(response.message);
            }else{
                location.reload();
            }

        });
        return false;
    }

</script>
</html>