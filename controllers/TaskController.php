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

            case "delete":
                $this -> delete();
            break;

            case "setTaskAsDone":
                $this -> setTaskAsDone();
            break;

            case "setTaskAsToDo":
                $this -> setTaskAsToDo();
            break;

            case "setStepAsDone":
                $this -> setStepAsDone();
            break;

            case "setStepAsToDo":
                $this -> setStepAsToDo();
            break;

            case "insertStep":
                $this -> insertStep();
            break;

            case "deleteStep":
                $this -> deleteStep();
            break;

            case "insert":
                $this -> insert();
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

    public function delete()
    {
        if(isset($_GET["id"]))
        {
            $Step = new Step($this -> connection);
            $Step -> setTaskId($_GET["id"]);
            $save = $Step -> deleteByTask();

            $Task = new Task($this -> connection);
            $Task -> setTaskId($_GET["id"]);
            $save = $Task -> delete();
            header('Location: index.php');
        }
    }

    public function setTaskAsDone(){
        $Task = new Task($this -> connection);
        $Task -> setTaskId($_GET["id"]);
        $save = $Task -> setTaskAsDone();
        header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
    }

    public function setTaskAsToDo(){
        $Task = new Task($this -> connection);
        $Task -> setTaskId($_GET["id"]);
        $save = $Task -> setTaskAsToDo();
        header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
    }

    public function setStepAsDone(){
        $Step = new Step($this -> connection);
        $Step -> setStepId($_GET["step_id"]);
        $save = $Step -> setStepAsDone();
        header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
    }

    public function setStepAsToDo(){
        $Step = new Step($this -> connection);
        $Step -> setStepId($_GET["step_id"]);
        $save = $Step -> setStepAsToDo();
        header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
    }

    public function insertStep(){
        if(isset($_POST['newStepTitle']) && $_POST['newStepTitle'][0] !== " "){
            $Step = new Step($this -> connection);
            $Step -> setTaskId($_GET["id"]);
            $Step -> setStepTitle($_POST['newStepTitle']);
            if($Step -> insert()){
                header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
            }else{
                header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
            }
        }else{
            header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
        }
    }

    public function deleteStep()
    {
        if(isset($_GET["id"]) && isset($_GET["step_id"]))
        {
            $Step = new Step($this -> connection);
            $Step -> setStepId($_GET["step_id"]);
            $save = $Step -> delete();
            header('Location: index.php?controller=Task&action=index&id='.$_GET["id"]);
        }
    }

    public function insert(){
        if(isset($_POST['title']) && $_POST['title'][0] !== " "){
            $Task = new Task($this -> connection);
            $Task -> setTaskTitle($_POST['title']);
            $Task -> setTaskComment($_POST['comment']);
            $datetime = $_POST['date'] . ' ' . $_POST['time'] . ":00";
            $Task -> setTaskDeadline($datetime);
            $Task -> setUserId($_POST['user_id']);
            $insert = $Task -> insert();

            $lastTask = $Task -> lastTaskId();
            $id = $lastTask -> task_id;

            if($insert){
                header('Location: index.php?controller=Task&action=index&id=' . $id);
            }else{
                header('Location: index.php?controller=Task&action=index');
            }
        }else{
            header('Location: index.php?controller=Task&action=index');
        }
    }

    public function view($name, $data)
    {
        require_once __DIR__ . "/../views/".$name."View.php";
    }
}