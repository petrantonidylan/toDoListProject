<?php

require_once 'config/global.php';
session_start();

if(isset($_SESSION['user_login'])){
    if(isset($_GET["controller"]))
    {
            $controllerObj = loadController($_GET["controller"]);
            loadAction($controllerObj);
    }else{
            $controllerObj = loadController(CONTROLLER_DEFAULT);
            loadAction($controllerObj);
    }
}else{
    $controllerObj = loadController("UserTask");
    loadAction($controllerObj);
}


function loadController($controller)
{
    switch($controller)
    {
        case 'Task' :
            $strFileController='controllers/TaskController.php';
            require_once $strFileController;
            $controllerObj = new TaskController();
        break;

        case 'UserTask' :
            $strFileController='controllers/UserTaskController.php';
            require_once $strFileController;
            $controllerObj = new UserTaskController();
        break;

        default:
            $strFileController = 'controllers/TaskController.php';
            require_once $strFileController;
            $controllerObj = new TaskController();
        break;
    }
    return $controllerObj;
}

function loadAction($controllerObj)
{
    if(isset($_GET["action"]))
    {
        $controllerObj -> run($_GET["action"]);
    }
    else
    {
        $controllerObj -> run(ACTION_DEFAULT);
    }
}

?>