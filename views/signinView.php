<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Sign in</title>
</head>

<body class="bg-info-subtle">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <img src="./files/logoToDoBlack2.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
            </div>
            <h4 class="card-title text-center mb-4">Sign in</h4>
            <form method="post">
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
                <div class="text-center mt-3">
                    <a href="index.php?controller=UserTask&action=signup">Sign up</a>
                </div>
            </form>
            <?php if(isset($data["error"])){
                echo "<div class='alert alert-danger bg-danger-subtle text-center' style='margin-top:10px'>" . $data["error"] . "</div>";
            } ?>
        </div>
    </div>

</body>

</html>