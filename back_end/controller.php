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
?>