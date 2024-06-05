<?php

class Step
{

    private $table="Step";
    private $connection;

    private $step_id;
    private $step_title;
    private $step_is_done;
    private $task_id;

    public function __construct($connection)
    {
        $this -> connection = $connection;
    }

    //SETTER

    public function setStepId($id)
    {
        $this -> step_id = $id;
    }

    public function setStepTitle($title)
    {
        $this -> step_title = $title;
    }

    public function setStepIsDone($is_done)
    {
        $this -> step_is_done = $is_done;
    }

    public function setTaskId($id)
    {
        $this -> task_id = $id;
    }

    //---------

    public function getAllByTaskId()
    {
        $query = $this -> connection -> prepare("SELECT * FROM ". $this -> table ." WHERE task_id = :id");
        $query -> bindParam(':id', $this -> task_id);
        $query -> execute();
        $result = $query -> fetchAll();
        return $result;
    }

}