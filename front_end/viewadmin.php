<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>TP10_PHP</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
                integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                crossorigin="anonymous"></script>
    </head>
    <body>

    <div class="container">
        <div class="row">
            <div class="col col-md-12" style="text-align: center">
            <br>
                <h1>Admin Page</h1>
                <a href="index.php"><input type="button" value="Accueil" class="btn btn-dark"/></a>
                <a href="view-newetudiant.php"><input type="button" value="Ajouter étudiant" class="btn btn-dark"/></a>
                <a href="viewlogin.php"><input type="submit" value="Déconnexion" class="btn btn-dark"/></a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php
                    include "controller.php";

                    $id = $_SESSION['id'];
                    $sql = "SELECT * FROM utilisateur WHERE id = '$id';";
                    $statement = $db->prepare($sql);
                    $statement->execute();
                    $result = $statement->fetch();

                    echo "<p>".$result['prenom'] . " " . $result['nom']."</p>";
                    ?>

                    <h3>Liste de vos étudiants</h3>
                    
                    <table class="table">
                    <thead>
                    <tr>
                   <!--     <th scope="col">#</th> -->
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Note</th>
                        <th scope="col">Mise à jour</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php


                $sql = "SELECT * FROM etudiant WHERE user_id = '$id'";
                $sth = $db->prepare($sql);
                $sth->execute();
                $sth = $sth->fetchAll();
                foreach ($sth as $data){
                    echo '
                    <tr>
                    <!--    <th scope="row">1</th> -->
                        <td>'.$data['nom'].'</td>
                        <td>'.$data['prenom'].'</td>
                        <td>'.$data['note'].'</td>
                        <td>
                            <form action="view-editetudiant.php" method="post">
                                <button type="submit" name="edit" value="'.$data['id'].'" class="btn btn-primary">Modifier</button>
                            </form>
                        </td>
                    </tr>
                ';
                }
                ?>
                    </tbody>
                </table>
              
            </div>
        </div>
    </div>

    </body>
    </html>
