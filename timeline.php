<?php
    session_start();
    require_once "util.php";
    // if not logged in then redirect to login.php
    if (!isUserLoggedIn()) {
        header("Location: /task_managment_project_web/index.php");
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">TASK Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#">Tasks <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="logout">Logout</a>
        </li>
        </ul>
    </div>
    </nav>

    <div class="container pt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Task</button>
    </div>
    <div class="container" id="allTasks">

    </div>
    


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Tasks</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form class="login">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Description</label>
                <textarea class="form-control" name="description" required col=4></textarea>
                </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Task Status</label>
                <select class="form-select" name="status" aria-label="Default select example">
                    <option value="1">Todo</option>
                    <option value="2">In progress</option>
                    <option value="3">Done</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary create-task">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

<script>
    $("#logout").click(function(){
        const endPoint = "http://localhost/task_managment_project_web/signout.php";
        $.get(endPoint, function(response){
            location.reload();
        });
        
    });
    

$(document).ready(function(){
    
    loadUserTasks();
});

function loadUserTasks(){
    const taskTemplate = 
        '<ul class="list-group pt-2">'+
            '<li class="list-group-item">'+
                '<div class="d-flex bd-highlight">'+
                    '<div class="p-2 flex-grow-1 ">'+
                    '<h5 class="card-title">{{title}}</h5>'+
                    '<p class="card-text">{{description}}</p>'+
                    '<small class="card-text">Created on: {{created_at}}</small>'+
                '</div>'+
                    '<div class="p-2">'+
                        '<div class="btn-group">'+
                            '<select class="form-select mt-4  pl-3 pr-3" aria-label="Default select example">'+
                                '<option value="todo" {{to_do_selected}}>ToDo</option>'+
                                '<option value="inProgress" {{inProgress_selected}}>In Progress</option>'+
                                '<option value="done" {{done_selected}}>Done</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '<div class="p-2">'+
                    '<button type="button" class="btn btn-danger mt-4">Delete</button>'+
                '</div>'+
                '</div>'+
            '</li>'+
        '</ul>';
    const endPoint = "http://localhost/task_managment_project_web/tasks_api.php";
    $.get(endPoint, function(response){
        let userTasksTemplate = "";
        for(let i = 0; i < response.data.length; i++){
            const currentTask = response.data[i];
            userTasksTemplate += taskTemplate.replace("{{title}}", currentTask.title)
                            .replace("{{description}}", currentTask.description)
                            .replace("{{"+currentTask.status+"_selected}}", "selected")
                            .replace("{{created_at}}", currentTask.created_at);
            // taskTemplate = taskTemplate.replace("{{todo_selected}}", "");
            // taskTemplate = taskTemplate.replace("{{inProgress_selected}}", "" );
            // taskTemplate = taskTemplate.replace("{{done_selected}}","");
        }

        $("#allTasks").html(userTasksTemplate);
    });
   
    
}


</script>
</html>