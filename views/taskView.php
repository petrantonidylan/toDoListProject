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

    <a href="index.php?controller=UserTask&action=logout"><?php echo $_SESSION['user_login'] . " "; ?><i class="fa-solid fa-power-off"></i></a>
    
    <div class="">

        <?php
        if($data["tasks"] == null){
            echo "No tasks to display.";
        }else{

        foreach($data["tasks"] as $task) {
        ?>

        <div class="">
            <?php echo $task["task_title"]; ?>
        </div>

        <?php }} ?>

    </div>

</body>
</html>