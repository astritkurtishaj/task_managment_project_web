<?php

require_once ("../utils/config.php");


function task_get_list() {

    $tasks = db_get_tasks();

    return json_encode($tasks);
}

function task_create() {
    $parameters = $_POST;

    return json_encode($parameters);


}

function task_delete() {

}

function task_update() {

}

function get_task_by_id() {
    $id = $_GET["id"];

    return $id;
}


$action = $_GET["action"] ?? null;

if (is_callable($action)) {
    $response =  call_user_func($action);

    echo $response;
    exit(1);
}

echo json_encode([
    "error" => "Invalid function"
]);

