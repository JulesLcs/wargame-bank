<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION)) { 
    session_start(); 
}
if(!empty($_GET['id'])) {
    if($_GET['id'] == 1) {
        $_SESSION['id'] = $_GET['id'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bankisen</title>
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
            <h1>Your account</h1>
            <a href="../front_end/viewlogin.php"><input type="submit" value="Déconnexion" class="btn btn-dark"/></a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
        <table class="table">
                        <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom expéditeur</th>
                        <th scope="col">Prénom expéditeur</th>
                        <th scope="col">Nom destinataire</th>
                        <th scope="col">Prénom destinataire</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Date</th>
                        </tr>
                        </thead>
                        <tbody>
            <?php
                include "../back_end/controller.php";

                if (isset($_SESSION['id'])) {
                    $id = $_SESSION['id'];
                    $sql = "SELECT nom,prenom,solde FROM users WHERE id = '$id';";
                    $statement = $db->prepare($sql);
                    $statement->execute();
                    $result = $statement->fetch();

                    echo "<p>".$result['prenom'] . " " . $result['nom']."</p>";
                    echo "<p> Votre solde : ".$result['solde']."€</p>";
                } else {
                    header('Location:../front_end/viewlogin.php');
                    exit(); 
                }
                
                if (isset($_POST['transaction_id'])) {
                    $transactionId = $_POST['transaction_id'];
                
                    $sql = "SELECT * FROM transferts WHERE id = :transaction_id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':transaction_id', $transactionId);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    if ($result) {
                        $mont_vuln = $result['montant'];
                        $vuln_sql = "SELECT t.id AS transfert_id,sender.nom AS sender_nom,sender.prenom AS sender_prenom,reciever.nom AS reciever_nom,reciever.prenom AS reciever_prenom, t.montant, t.date FROM transferts t INNER JOIN users AS sender ON t.sender_id = sender.id INNER JOIN users AS reciever ON t.reciever_id = reciever.id WHERE t.montant = '$mont_vuln';";
                        $vuln_statement = $db->prepare($vuln_sql);
                        $vuln_statement->execute();
                        $vuln_result = $vuln_statement->fetch();
                        echo '
                        <tr>
                        <!--    <th scope="row">1</th> -->
                        <td>'.$vuln_result['transfert_id'].'</td>
                        <td>'.$vuln_result['sender_nom'].'</td>
                        <td>'.$vuln_result['sender_prenom'].'</td>
                        <td>'.$vuln_result['reciever_nom'].'</td>
                        <td>'.$vuln_result['reciever_prenom'].'</td>
                        <td>'.$vuln_result['montant'].'</td>
                        <td>'.$vuln_result['date'].'</td>
                        </tr>
                        ';
                        } else {
                            echo '<p>Aucune transaction trouvée pour l\'ID ' . $transactionId . '</p>';
                        }
                }
                ?>
                </tbody>
            </table>
                <form method="post" action="">
                <label for="transaction_id">Chercher transfert via ID : </label>
                <input type="text" id="transaction_id" name="transaction_id" required>
                <button type="submit" class="btn btn-primary">Afficher les détails</button>
                </form>
                <br><br><br>
                <h3>Liste de vos envois</h3>
                
                <table class="table">
                <thead>
                <tr>
                <!--     <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Destinataire</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
            <?php


            $sql = "SELECT t.id,users.nom,users.prenom,montant, date FROM transferts t INNER JOIN users on t.reciever_id=users.id WHERE t.sender_id=:id;";
            $sth = $db->prepare($sql);
            $sth->bindParam(':id', $id);
            $sth->execute();
            $sth = $sth->fetchAll();
            foreach ($sth as $data){
                echo '
                <tr>
                <!--    <th scope="row">1</th> -->
                    <td>'.$data['id'].'</td>
                    <td>'.$data['prenom']." ".$data['nom'].'</td>
                    <td>'.$data['montant'].'</td>
                    <td>'.$data['date'].'</td>
                </tr>
            ';
            }
            ?>
                </tbody>
            </table>
            <h3>Liste de vos receptions</h3>
                
                <table class="table">
                <thead>
                <tr>
                <!--     <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Expéditeur</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
            <?php

            $sql = "SELECT t.id,users.nom,users.prenom,montant, date FROM transferts t INNER JOIN users on t.sender_id=users.id WHERE t.reciever_id=:id;";
            $sth = $db->prepare($sql);
            $sth->bindParam(':id', $id);
            $sth->execute();
            $sth = $sth->fetchAll();
            foreach ($sth as $data){
                echo '
                <tr>
                <!--    <th scope="row">1</th> -->
                    <td>'.$data['id'].'</td>
                    <td>'.$data['prenom']." ".$data['nom'].'</td>
                    <td>'.$data['montant'].'</td>
                    <td>'.$data['date'].'</td>
                </tr>
            ';
            }
            ?>
                </tbody>
            </table>
            
            <!-- Formulaire pour effectuer un transfert -->
            <form method="post" action="../back_end/controller.php?func=transfert">
            <div class="form-group">
                <label for="montant">Montant à donner (en euros) :</label>
                <input type="number" class="form-control" id="montant" name="montant" min="0" required>
            </div>
            <div class="form-group">
                <label for="destinataire">Destinataire :</label>
                <select class="form-control" id="destinataire" name="destinataire" required>
                <option value="">Sélectionnez le destinataire</option>
                <?php
                $sql = "SELECT id,nom,prenom FROM  users WHERE id != :id";
                $sth = $db->prepare($sql);
                $sth->bindParam(':id', $id);
                $sth->execute();
                $sth = $sth->fetchAll();
                
                foreach ($sth as $data) {
                    echo '<option value="' . $data['id'] . '">' . $data['prenom'] . ' ' . $data['nom'] . '</option>';
                }
                ?>
                </select>
                </div>
                <button type="submit" class="btn btn-primary">Effectuer le transfert</button>
                </form>


        </div>
    </div>
<br><br>
</div>

</body>
</html>
