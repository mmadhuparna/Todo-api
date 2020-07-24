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

    $item->user_id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $stmt= $item->getOneTodo();
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
           

        
    }
    
    echo json_encode($result,JSON_PRETTY_PRINT);
}

else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
?>