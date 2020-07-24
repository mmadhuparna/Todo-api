<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../class/todo.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Todo($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // todo values
    $item->user_id = $data->user_id;
    $item->name = $data->name;
    $item->description = $data->description;
    $item->task_id = $data->task_id;
    $item->task_name = $data->task_name;
    $item->task_description = $data->task_description;
    echo json_encode($item->id);
    $item->updateTodo();
       
?>