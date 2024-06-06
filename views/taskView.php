<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Tasks</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 sidebar bg-info-subtle">
            <div class="text-center mb-4" style="margin-top: 15px">
                <img src="./files/logoToDoBlack2.png" alt="Logo" class="img-fluid" style="max-width: 120px;">
            </div>
            <div class="text-center mb-4">
                <a href="index.php?controller=UserTask&action=logout" class="btn btn-primary"><i class="fa-regular fa-user"></i> <?php echo $_SESSION['user_login'] . " "; ?><i class="fa-solid fa-power-off"></i></a>
            </div>    
                <ul class="list-group">
                <?php
                    if($data["tasks"] == null){
                        echo "No tasks to display.";
                    }else{

                    foreach($data["tasks"] as $task) {
                        if(!$task['task_is_done'])
                        {
                            $title = $task["task_title"];
                        }else
                        {
                            $title = "<del>" . $task["task_title"] . "</del>";
                        }
                        if($_GET['id'] == $task["task_id"]){
                            $class = "bg-primary-subtle";
                        }else{
                            $class = "";
                        }
                    ?>
                        <?php echo "<li class='list-group-item d-flex justify-content-between " . $class . "'><a class='text-decoration-none' href='index.php?controller=Task&id=". $task["task_id"] ."'>" . $title . "</a><a href='index.php?controller=Task&action=delete&id=" . $task["task_id"] . "' onclick='return confirmDelete(this);' class='text-danger'><i class='fa-solid fa-trash-can'></i></a></li>"; ?>
                <?php }} ?>
                </ul>
            </div>
            <div class="col-9">
                <?php
                if(isset($data["currentTask"])){
                    if($data["currentTask"]){
                        if($data["currentTask"] -> task_is_done)
                        {
                            $status = "Done";
                            $link = "<a href='index.php?controller=Task&action=setTaskAsToDo&id=" . $data["currentTask"] -> task_id . "' class='btn btn-warning btn-sm'>Set as « to do » <i class='fa-solid fa-rotate-left'></i></a>";
                        }else{
                            $status = "To do";
                            $link = "<a href='index.php?controller=Task&action=setTaskAsDone&id=" . $data["currentTask"] -> task_id . "' class='btn btn-success btn-sm'>Set as « done » <i class='fa-solid fa-check'></i></a>";
                        }
                        echo "<h2>" . $data["currentTask"] -> task_title . " - Status : " . $status . " " . $link . "</h2>";
                        $dateTime = new DateTime($data["currentTask"] -> task_created_at);
                        $formattedDate = $dateTime -> format('d/m/Y');
                        echo "<p>Created at " . $formattedDate ."</p>";
                        $dateTime2 = new DateTime($data["currentTask"] -> task_deadline);
                        echo "<p>Deadline : " . $dateTime2->format('d/m/Y') . " at " . $dateTime2->format('H:i') . "</p>";
                        echo "<p>Comment : " . $data["currentTask"] -> task_comment ."</p>";
                        echo "<hr>";
                    }
                }else{
                    echo "<h2>Please, select a task.</h2>";
                }
                if(isset($data["steps"]))
                {
                    echo "Step(s):<br>";
                    $n = 1;
                    foreach($data["steps"] as $step){
                        if(!$step['step_is_done']){
                            $link2="<a href='index.php?controller=Task&action=setStepAsDone&step_id=" . $step['step_id'] . "&id=" . $data["currentTask"] -> task_id . "'><i class='fa-regular fa-square'></i></a>";
                        }else{
                            $link2="<a href='index.php?controller=Task&action=setStepAsToDo&step_id=" . $step['step_id'] . "&id=" . $data["currentTask"] -> task_id . "'><i class='fa-regular fa-square-check'></i></a>";
                        }
                        echo "&nbsp&nbsp". $link2 ." Step ". $n . " : " .$step['step_title'] ."<br>";
                        $n ++;
                    }
                    $n = 1;
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        function confirmDelete(link) {
            var confirmation = confirm("Do you really want to delete this task ?");
            if (confirmation) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>