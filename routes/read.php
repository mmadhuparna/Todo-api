<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/todo.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Todo($db);

    $stmt = $items->gettodos();
    $itemCount = $stmt->rowCount();

    

    if($itemCount > 0){
        
        $employeeArr = array();
       

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            if (!isset($result[$row["user_id"]])) {
                $result[$row["user_id"]] = array(
                "id" => $id,
                "user_id" => $user_id,
                "name" => $name,
                "description" => $description,
                "tasks"=>array(array_slice($row,-3)));
            }
            else{
                $result[$row['user_id']]["tasks"][] = array_slice($row,-3);
            }
               // "task_id" => $task_id,
                //"task_name" => $task_name,
                //"task_description" => $task_description
            //);

            
        }
        
        echo json_encode($result);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>