<?php

use FTP\Connection;

class TaskController
{
    private $connector;
    private $connection;

    public function __construct()
    {
        require_once __DIR__ . "/../core/Connector.php";
        require_once __DIR__ ."/../models/Task.php";
        require_once __DIR__ ."/../models/Step.php";

        $this -> connector = new Connector();
        $this -> connection = $this -> connector -> connection();
    }

    public function run($action)
    {
        switch($action)
        {
            case "index":
                $this -> index();
            break;

            default:
                $this -> index();
            break;
        }
    }

    public function index()
    {
        $Task = new Task($this -> connection);
        $Tasks = $Task -> getAllByUser($_SESSION["user_login"]);

        if(isset($_GET["id"]))
        {
            $CurrentTask = $Task -> getById($_GET["id"]);
            
            $Step = new Step($this -> connection);
            $Step -> setTaskId($CurrentTask -> task_id);
            $Steps = $Step -> getAllByTaskId();

            if($Steps){
                $this -> view("task", array("tasks" => $Tasks, "currentTask" => $CurrentTask, "steps" => $Steps));
            }else{
                $this -> view("task", array("tasks" => $Tasks, "currentTask" => $CurrentTask));
            }
        }else{
            $this -> view("task", array("tasks" => $Tasks));
        }
    }

    public function view($name, $data)
    {
        require_once __DIR__ . "/../views/".$name."View.php";
    }
}