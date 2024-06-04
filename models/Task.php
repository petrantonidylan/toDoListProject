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
        $query = $this -> connection -> prepare("SELECT * FROM " . $this -> table . ", UserTask WHERE Task.user_id = UserTask.user_id AND user_login = :login");
        $query->bindParam(':login', $p_user_login);
        $query -> execute();
        $result = $query -> fetchAll();
        $this -> connection = null;
        return $result;
    }
}