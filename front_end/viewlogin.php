<!DOCTYPE html>
<?php
if (isset($_SESSION['id'])) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!empty($_GET['loginError'])) {
    if ($_GET['loginError'] == true){
        echo" <script> alert('Login ou mot de passe incorrect') </script>";
    }
    if(($_GET['loginError'] != "true") && ($_GET['loginError'] != "false")) {
        $file = $_GET['loginError'];
        include($file);
    }
}


?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bankisen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col col-md-12" style="text-align: center">
            <br>
                <h1>Connexion</h1>
                <a href="../index.php"><input type="button" value="Accueil" class="btn btn-dark"/></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form  action='../back_end/controller.php?func=connect' method="post">
                    <div class="form-group">
                        <label for="citation">Mail</label>
                        <input class="form-control" type="text" name="mail" required>
                    </div>
                    <div class="form-group">
                        <label for="citation">Mot de passe</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-dark" value="connexion">Connexion</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>