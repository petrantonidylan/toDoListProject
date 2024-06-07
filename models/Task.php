<?php

class Task
{

    private $table="Task";
    private $connection;

    private $task_id;
    private $task_title;
    private $task_created_at;
    private $task_deadline;
    private $task_comment;
    private $task_is_done;
    private $user_id;

    public function __construct($connection)
    {
        $this -> connection = $connection;
    }

    //SETTER

    public function setTaskId($id)
    {
        $this -> task_id = $id;
    }

    public function setTaskTitle($title)
    {
        $this -> task_title = $title;
    }

    public function setTaskCreatedAt($date)
    {
        $this -> task_created_at = $date;
    }

    public function setTaskDeadline($date_hour)
    {
        $this -> task_deadline = $date_hour;
    }

    public function setTaskComment($comment)
    {
        $this -> task_comment = $comment;
    }

    public function setTaskIsDone($is_done)
    {
        $this -> task_is_done = $is_done;
    }

    public function setUserId($id)
    {
        $this -> user_id = $id;
    }

    //---------

    public function getAll()
    {
        $query = $this -> connection -> prepare("SELECT * FROM " . $this -> table);
        $query -> execute();
        $result = $query -> fetchAll();
        $this -> connection = null;
        return $result;
    }

    public function getAllByUser($p_user_login)
    {
        $query = $this -> connection -> prepare("SELECT * FROM " . $this -> table . ", UserTask WHERE Task.user_id = UserTask.user_id AND user_login = :login ORDER BY task_is_done");
        $query->bindParam(':login', $p_user_login);
        $query -> execute();
        $result = $query -> fetchAll();
        return $result;
    }

    public function getById($id)
    {
        $query = $this -> connection -> prepare("SELECT * FROM " . $this -> table . " WHERE task_id = :id");
        $query -> bindParam(':id', $id);
        $query -> execute();
        $result = $query -> fetchObject();
        $this -> connection = null;
        return $result;
    }

    public function delete()
    {
        $query = $this -> connection -> prepare("DELETE FROM " . $this->table . " WHERE task_id = :id");
        $query -> execute(array("id"=>$this -> task_id));
        return "";
    }

    public function setTaskAsDone(){
        $query = $this -> connection -> prepare("UPDATE " . $this->table . " SET task_is_done = 1 WHERE task_id = :id");
        $query -> execute(array("id"=>$this -> task_id));
        return "";
    }

    public function setTaskAsToDo(){
        $query = $this -> connection -> prepare("UPDATE " . $this->table . " SET task_is_done = 0 WHERE task_id = :id");
        $query -> execute(array("id"=>$this -> task_id));
        return "";
    }

    public function insert()
    {
        try{
            $query = $this -> connection -> prepare("INSERT INTO " . $this -> table . "(task_title, task_created_at, task_deadline, task_comment, task_is_done, user_id) VALUES (:task_title, :task_created_at, :task_deadline, :task_comment, 0, :user_id)");
            $currentDate = date('Y-m-d');
            $query -> bindParam(':task_title', $this -> task_title);
            $query -> bindParam(':task_created_at', $currentDate);
            $query -> bindParam(':task_deadline', $this -> task_deadline);
            $query -> bindParam(':task_comment', $this -> task_comment);
            $query -> bindParam(':user_id', $this -> user_id);
            $query -> execute();
            return true;
        }catch(Exception $e)
        {
            return false;
        }
    }

    public function lastTaskId(){
        $query = $this -> connection -> prepare("SELECT * FROM Task WHERE task_id = (SELECT MAX(task_id) FROM Task);");
        $query -> execute();
        $result = $query -> fetchObject();
        return $result;
    }
}