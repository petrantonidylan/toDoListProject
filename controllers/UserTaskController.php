<?php

use FTP\Connection;

class UserTaskController
{
    private $connector;
    private $connection;

    public function __construct()
    {
        require_once __DIR__ . "/../core/Connector.php";
        require_once __DIR__ ."/../models/UserTask.php";

        $this -> connector = new Connector();
        $this -> connection = $this -> connector -> connection();
    }

    public function run($action)
    {
        switch($action)
        {
            case "signin":
                $this -> signin();
            break;

            case "logout":
                $this -> logout();
            break;

            case "signup":
                $this -> signup();
            break;

            default:
                $this -> signin();
            break;
        }
    }

    public function signin()
    {
        if(isset($_POST["login"]) && isset($_POST["pass"])){
            $User = new UserTask($this->connection);
            if($User->authenticate($_POST["login"], $_POST["pass"]))
            {
                $_SESSION['user_login'] = $_POST["login"];
                header('Location: index.php?controller=Task');
                exit;
            }else
            {
                $this -> view("signin", array("error" => "Wrong credentials."));
            }
        }else{
            $this -> view("signin", array());
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?controller=UserTask&action=signin');
    }

    public function signup()
    {
        if(isset($_POST["login"]) && isset($_POST["pass_1"]) && isset($_POST["pass_2"])){
           if($_POST["pass_1"] == $_POST["pass_2"])
           {
                $User = new UserTask($this->connection);
                $User -> setUserLogin($_POST["login"]);
                $User -> setUserPass($_POST["pass_1"]);

                if($User -> insert())
                {
                    $_SESSION['user_login'] = $_POST["login"];
                    header('Location: index.php?controller=Task');
                    exit;
                }else
                {
                    $this -> view("signup", array("error" => "This login already exists."));
                }
           }else{
                $this -> view("signup", array("error" => "The password and the confirmation must be the same."));
           }
        }else{
            $this -> view("signup", array());
        }
    }

    public function view($name, $data)
    {
        require_once __DIR__ . "/../views/".$name."View.php";
    }
}