<?php

include "database.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_SESSION)) { 
    session_start(); 
}

$db = dbConnect();
if (isset($_GET['func'])) {
    $_GET['func']($db);
}

function insertnewuser($db) {
    $nom = $_POST['lastname'];
    $prenom = $_POST['forname'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $passwordVerification = $_POST['passwordverification'];

    if ($password != $passwordVerification) {
        header('Location: ../front_end/viewnewuser.php?error=MDP');
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (pwd, mail, nom, prenom) VALUES (:password, :mail, :nom, :prenom)";
    $statement = $db->prepare($sql);
    $statement->bindParam(':password', $passwordHash);
    $statement->bindParam(':mail', $mail);
    $statement->bindParam(':nom', $nom);
    $statement->bindParam(':prenom', $prenom);
    $statement->execute();

    header('Location: ../index.php');

}

function connect($db){
    $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];  
    $query = "SELECT id, mail, pwd FROM users WHERE mail = :mail";
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $db->errorInfo()[2]);
    }
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $result = $stmt->fetch();
    if (!$result) {
        header('Location:../front_end/viewlogin.php?loginError=true');
        exit();
    
    } else if (password_verify($password, $result['pwd']) && $result) {
        $_SESSION['id'] = $result['id'];
        header('Location:../front_end/viewadmin.php');
        exit();
    
    } else {
        header('Location:../front_end/viewlogin.php?loginError=true');
    }
}

function verify_solde($db,$montant){
    $query = "SELECT solde FROM users WHERE id = :expediteur_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':expediteur_id', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($montant > $result['solde']) {
        echo "Solde insuffisant pour effectuer le transfert.";
        exit;
    }
}

function transfert($db){
    //creation de l'objet transfert
    $montant = $_POST['montant'];
    $float_montant = (double)floatval($montant);
    $destinataire = $_POST['destinataire'];
    verify_solde($db,$float_montant);
    $db->beginTransaction();
    try{
        $query = "INSERT INTO transferts (sender_id, reciever_id, montant) VALUES (:expediteur_id, :destinataire_id, :montant)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':expediteur_id', $_SESSION['id']);
        $stmt->bindParam(':destinataire_id', $destinataire);
        $stmt->bindParam(':montant', $montant);
        $stmt->execute();

        //maj des soldes des comptes
        $query = "UPDATE users SET solde = solde-:montant WHERE id = :expediteur_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':montant',$float_montant);
        $stmt->bindParam(':expediteur_id', $_SESSION['id']);
        $stmt->execute();

        $query = "UPDATE users SET solde = solde +:montant WHERE id = :destinataire_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':montant',$float_montant);
        $stmt->bindParam(':destinataire_id', $destinataire);
        $stmt->execute();


        $db->commit();
        header('Location:../front_end/viewadmin.php');  
    } catch (Exception $e) {
    $db->rollBack();
    error_log("Erreur lors du transfert : " . $e->getMessage());
    echo "Une erreur s'est produite lors du traitement de la transaction. Veuillez réessayer plus tard.";
}

}
?>
