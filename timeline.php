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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ms-3">
        <a class="navbar-brand" href="#">TASK Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Tasks</a>
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
        <form onkeyup="validateInputs();" class="add_task" id="add_task" name="add_task"onsubmit="return storeTask();">
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Title</label>
                <input type="text" class="form-control " name="title"  id="title" aria-describedby="titleHelp">
                <div id="title_message"></div>
            </div>
            <div class="mb-3">
                <label for="exampleInputDescription" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description"  col=4></textarea>
                <div id="description_message"></div>
                </div>
            <div class="mb-3">
                <label for="exampleInputOption" class="form-label">Task Status</label>
                <select class="form-select" name="status" id="status" aria-label="Default select example">
                    <option value="todo">Todo</option>
                    <option value="inProgress">In progress</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary create-task" id="save_task" onclick="storeTask();">Save</button>
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
            '<li class="list-group-item" id="line_task_{{line_id_task}}">'+
                '<div class="d-flex bd-highlight">'+
                    '<div class="p-2 flex-grow-1 ">'+
                    '<h5 class="card-title">{{title}}</h5>'+
                    '<p class="card-text">{{description}}</p>'+
                    '<small class="card-text">Created on: {{created_at}}</small>'+ '&nbsp'+ '&nbsp'+
                    '<small class="card-text">Created by: {{created_by}}</small>'+
                '</div>'+
                    '<div class="p-2">'+
                        '<div class="btn-group">'+
                            '<select class="form-select mt-4 pl-3 pr-3" id="mySelect" onchange="updateTask({{id_task_update}},{{id_user_update}});" aria-label="Default select example">'+
                                '<option value="todo" {{to_do_selected}}>ToDo</option>'+
                                '<option value="inProgress" {{inProgress_selected}}>In Progress</option>'+
                                '<option value="done" {{done_selected}}>Done</option>'+
                            '</select>'+
                        '</div>'+
                    '</div>'+
                '<div class="p-2">'+
                    '<button type="button" class="btn btn-danger mt-4 delete" id="btndelete" onclick="deleteTask({{id_task}},{{id_user}})">Delete</button>'+
                '</div>'+
                '</div>'+
            '</li>'+ 
        '</ul>';
    const endPoint = "http://localhost/task_managment_project_web/tasks_api.php";
    
    $.get(endPoint, function(response){
        let userTasksTemplate = "";
        for(let i = 0; i < response.data.length; i++){
            const currentTask = response.data[i];
            userTasksTemplate += taskTemplate.replace("{{title}}", escapeHtml(currentTask.title))
                            .replace("{{description}}", escapeHtml(currentTask.description))
                            .replace("{{"+currentTask.status+"_selected}}", "selected")
                            .replace("{{created_at}}", currentTask.created_at)
                            .replace("{{created_by}}", currentTask.full_name)
                            .replace("{{id_task}}", currentTask.id_task)
                            .replace("{{id_task_update}}", currentTask.id_task)
                            .replace("{{line_id_task}}", currentTask.id_task)
                            .replace("{{id_user}}", currentTask.id_user)
                            .replace("{{id_user_update}}", currentTask.id_user);
                           
                            
        };
        $("#allTasks").html(userTasksTemplate);
    }); 
}

function updateTask(idTask, idUser){
    var new_status = $("#mySelect").val();
    var id_task = idTask;
    var id_user = idUser;

    const apiEndpoint = "http://localhost/task_managment_project_web/update_task_logic.php";
    if(confirm("Are you sure you want to update the status of this task?!")){
        $.post(apiEndpoint, {
            'id_task': id_task,
            'status': new_status,
            'id_user': idUser
        }).done(function(response){ 
            if(response.success == false){
                alert(response.message);
            }else{
                $("option").value(new_status);
            }
        });
        return false;
    }
};


function deleteTask(idTask, idUser){
    const apiEndpoint = "http://localhost/task_managment_project_web/delete_task_logic.php";
    const id_task = idTask;
    const id_user = idUser;
    if(confirm("Are you sure you want to delete this task?!")){
        $.post(apiEndpoint, {
            'id_task': id_task,
            'id_user': id_user
        }).done(function(response){ 
            if(response.success == false){
                alert(response.message);
            }else{
                $("#line_task_"+id_task).remove();
            }
        });
        return false;
    }
};
function storeTask(){
    const title = $("#title").val();
    const description = $("#description").val();
    const status = $("#status").val();
    const apiEndpoint = "http://localhost/task_managment_project_web/task_logic.php";

        
        if(validateInputs() != true){
            return false;
        }
        
        else{
            $.post(apiEndpoint, {
                'title': title,
                'description': description,
                'status': status
            }).done(function(response){ 
                if(response.success == false){
                    alert(response.message);
                }else{
                    loadUserTasks();
                    $('#exampleModal').modal('hide');
                    $('#exampleModal').on('hidden.bs.modal', function () {
                        $(this).find("input,textarea").val('').end();
                    });
                }
            });
            return false;
        }        
} 

function validateInputs(){
    const title = $("#title").val().trim();
    const description = $("#description").val().trim();
    const status = $("#status").val();

    if(validateTitle(title) != true || validateDescription(description) != true){
        return false;
    }
    else{
        return true;
    }
}

function validateTitle(title){
    if(title.length < 5){
        $("#title").css("border-color", "red");
        $("#title_message").text("Title must be more than 4 charaters!!").css("color", "red").css("font-size", "12px");
        return false;

    }else{
        $("#title").css("border-color", "green");
        $("#title_message").text("");
        return true;
    }

}

function validateDescription(description){
    if(description.length < 7){
        $("#description").css("border-color", "red");
        $("#description_message").text("Description must be more than 6 characters!!").css("color", "red").css("font-size", "12px");
        return false;
    }else{
        $("#description").css("border-color", "green");
        $("#description_message").text("");
        return true;
    } 
}

function escapeHtml(str) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return str.replace(/[&<>"']/g, function(m) {
        return map[m];
    });
}
</script>
</html>