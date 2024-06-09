<?php require_once('errorHandling.php') ?>
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
    <div class="insert_container" id="insert_container">
        <div class="container mt-5 d-flex align-items-center justify-content-center full-height">
        <div class="card p-4 shadow" style="width:40%;margin-top:50px;">
            <h3 class="card-title">Add a new task</h3>
            <form method="post" action="index.php?controller=Task&action=insert">
                <div class="mb-3">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                    <?php echo "<input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'>"; ?>
                </div>
                <div class="mb-3">
                    <textarea class="form-control fixed-size-textarea" id="comment" name="comment" placeholder="Comment" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Deadline datetime :</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="mb-3">
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <button class="theButton" onclick="hideAddForm()">Close this windows</button>
        </div>
    </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 sidebar bg-info-subtle">
            <div class="text-center mb-4" style="margin-top: 15px">
                <img src="./files/logoToDoBlack2.png" alt="Logo" class="img-fluid" style="max-width: 120px;">
            </div>
            <div class="text-center mb-4">
                <a href="index.php?controller=UserTask&action=logout" class="btn btn-primary"><i class="fa-regular fa-user"></i> <?php echo $_SESSION['user_login'] . " "; ?><i class="fa-solid fa-power-off"></i></a><br><br>
                <h4>My tasks:</h4>
                <button class='btn btn-success' onclick="displayAddForm()">Add <i class="fa-solid fa-plus"></i></button>
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
                        if(isset($_GET['id'])){
                            if($_GET['id'] == $task["task_id"]){
                                $class = "bg-primary-subtle";
                            }else{
                                $class = "";
                            }
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
                        echo "Step(s):<br>";
                        echo "
                        <form method='post' action ='index.php?controller=Task&action=insertStep&id=" . $_GET['id'] . "'>
                            <input type='text' name='newStepTitle' placeholder='New step' required>
                            <input type='submit' value='Add'>
                        </form><br>";
                    }
                }else{
                    echo "<h2>Please, select a task.</h2>";
                } ?>



                <?php
                if(isset($data["steps"]))
                {
                    $n = 1;
                    foreach($data["steps"] as $step){
                        if(!$step['step_is_done']){
                            $link2="<a href='index.php?controller=Task&action=setStepAsDone&step_id=" . $step['step_id'] . "&id=" . $data["currentTask"] -> task_id . "'><i class='fa-regular fa-square'></i></a>";
                        }else{
                            $link2="<a href='index.php?controller=Task&action=setStepAsToDo&step_id=" . $step['step_id'] . "&id=" . $data["currentTask"] -> task_id . "'><i class='fa-regular fa-square-check'></i></a>";
                        }
                        echo "&nbsp&nbsp". $link2 ." <a href='index.php?controller=Task&action=deleteStep&id=" . $step['task_id'] . "&step_id=" . $step['step_id'] ."' class='text-danger'><i class='fa-solid fa-trash-can'></i></a> Step ". $n . " : " .$step['step_title'] . "</li><br>";
                        $n ++;
                    }
                    $n = 1;
                }
                ?>
                <?php 
                    if(isset($_GET["error"])){
                        echo "<div class='alert alert-danger bg-danger-subtle text-center' style='margin-top:10px'>" . errorHandling($_GET["error"]) . "</div>";
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

        function hideAddForm() {
            const div = document.getElementById('insert_container');
            div.style.display = 'none';
        }

        function displayAddForm() {
            const div = document.getElementById('insert_container');
            div.style.display = 'block';
        }
    </script>
</body>
</html>