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
            $tab = $User->authenticate($_POST["login"], $_POST["pass"]);
            if($tab['response'])
            {
                $_SESSION['user_login'] = $_POST["login"];
                $_SESSION['user_id'] = $tab['user_id'];
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
            if(preg_match('/[A-Z]/', $_POST["pass_1"]) && preg_match('/[a-z]/', $_POST["pass_1"]) && preg_match('/[0-9]/', $_POST["pass_1"]) && preg_match('/[\W_]/', $_POST["pass_1"]) && strlen($_POST["pass_1"]) >= 8){
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
                $this -> view("signup", array("error" => "The password must have, at least, one lowercase letter, one uppercase letter, one number, and count at least 8 caracters."));
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