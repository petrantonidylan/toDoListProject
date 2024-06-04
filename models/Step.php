<?php

class Step
{

    private $table="Step";
    private $connection;

    private $step_id;
    private $step_title;
    private $step_is_done;

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

    //---------

}