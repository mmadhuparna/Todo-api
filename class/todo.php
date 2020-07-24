<?php
    class Todo{

        // Connection
        private $conn;

        // Table
        private $db_table = "todo";

        // Columns
        public $id;
        public $user_id;
        public $name;
        public $description;
        public $task_id;
        public $task_name;
        public $task_description;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function gettodos(){
            $sqlQuery = "SELECT id, user_id, name, description, task_id, task_name, task_description  FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function addTodo(){
            $sqlQuery = "INSERT INTO ". $this->db_table ."(user_id,name,description,task_id,task_name,task_description) VALUES(:user_id,:name,:description,:task_id,:task_name,:task_description)";
            $stmt = $this->conn->prepare($sqlQuery);
            
            // bind data
            $stmt->bindParam(":user_id", $this->user_id,PDO::PARAM_STR);
            $stmt->bindParam(":name", $this->name,PDO::PARAM_STR);
            $stmt->bindParam(":description", $this->description,PDO::PARAM_STR);
            
            $stmt->bindParam(":task_id", $this->task_id,PDO::PARAM_STR);
            $stmt->bindParam(":task_name", $this->task_name,PDO::PARAM_STR);
            $stmt->bindParam(":task_description", $this->task_description,PDO::PARAM_STR);
            //$stmt->execute();
        echo json_encode($stmt);
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // GET ONE
        public function getOneTodo(){
            $sqlQuery = "SELECT
                        user_id, 
                        name, 
                        description, 
                        task_id, 
                        task_name, 
                        task_description
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       user_id = ?";
                    

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->user_id);

            $stmt->execute();
            return $stmt;
           
        }        

        // UPDATE
        public function updateTodo(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                        SET
                        user_id=:user_id,
                        name = :name, 
                        description = :description, 
                        task_id = :task_id, 
                        task_name = :task_name, 
                        task_description = :task_description
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            
            $stmt->bindParam(":task_id", $this->task_id);
            $stmt->bindParam(":task_name", $this->task_name);
            $stmt->bindParam(":task_description", $this->task_description);
        //echo json_encode($this->user_id);
            if($stmt->execute()){
               return true;
               echo 'success';
            }
            return false;
        }

        // DELETE
        function deleteTodo(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>
