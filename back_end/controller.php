<?php
session_start();

include "database.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    header('Location: ../front_end/index.php');

}

function connect($db){
    $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    
    $query = "SELECT id,mail,pwd FROM users WHERE mail = :mail AND pwd = :password";
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $db->errorInfo()[2]);
    }
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $result = $stmt->fetch($db::FETCH_ASSOC);

    if ($result) {
        $_SESSION['id'] = $result['id'];
        header('Location:../front_end/viewadmin.php');        
    }
    else
        header('Location:../front_end/viewlogin.php?loginError=true');
}

// function connect($db){
//     $mail = $_POST['mail'];
//     $password = $_POST['password'];
//     $sql= "SELECT id, mail, pwd FROM users WHERE mail = '".$mail."';";
//     $sth = $db->prepare($sql);
//     $sth->execute();
//     $result = $sth->fetch();
//     if (password_verify($password, $result['password'])) {
//         $_SESSION['id'] = $result['id'];
//         header('Location:../front_end/viewadmin.php');        
//     }
//     else
//         header('Location:../front_end/viewlogin.php?loginError=true');
// }

?>