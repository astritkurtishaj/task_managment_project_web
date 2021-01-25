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
        $("#name_message").text("Name is required!!").css("color", "red").css("font-size", "12px");
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
        $("#email_message").text("Email is required!!").css("color", "red").css("font-size", "12px");
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



//timeline javascript


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
    }else{
        loadUserTasks();
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