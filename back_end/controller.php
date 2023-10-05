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
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordVerification = $_POST['passwordverification'];

    if ($password != $passwordVerification) {
        header('Location: viewnewuser.php?error=MDP');
    }/* 

    $sql = "select login from utilisateur where login = '$login'";
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    if (!empty($result)) {
        header('Location: viewnewuser.php?error=Login');
    }


    $sql = "select mail from utilisateur where mail = '$mail'";
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    if (!empty($result)) {
        header('Location: viewnewuser.php?error=Mail');
    }*/

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateur (login, password, mail, nom, prenom) VALUES (:login, :password, :mail, :nom, :prenom)";
    $statement = $db->prepare($sql);
    $statement->bindParam(':login', $login);
    $statement->bindParam(':password', $passwordHash);
    $statement->bindParam(':mail', $mail);
    $statement->bindParam(':nom', $nom);
    $statement->bindParam(':prenom', $prenom);
    $statement->execute();

    header('Location: index.php');

}


function connect($db){
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql= "SELECT id, login, password FROM utilisateur WHERE login = '$login';";
    $sth = $db->prepare($sql);
    $sth->execute();
    $result = $sth->fetch();

    if (password_verify($password, $result['password'])) {
        $_SESSION['id'] = $result['id'];
        header('Location:viewadmin.php');        
    }
    else
        header('Location:viewlogin.php?loginError=true');
}

function addEtu($db) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $note = $_POST['note'];
    $id_prof = $_SESSION['id'];
    
    $sql = "INSERT INTO etudiant (user_id, nom, prenom, note) VALUES (:prof, :nom, :prenom, :note)";
    $statement = $db->prepare($sql);
    $statement->bindParam(':prof', $id_prof);
    $statement->bindParam(':nom', $nom);
    $statement->bindParam(':prenom', $prenom);
    $statement->bindParam(':note', $note);
    $statement->execute();

    header('Location: viewadmin.php');
}

function editEtu($db)
{
    $sql = "UPDATE etudiant SET nom = :nom, prenom = :prenom, note = :note WHERE id = :prof";
    $statement = $db->prepare($sql);
    $statement->bindParam(':nom', $_POST['nom']);
    $statement->bindParam(':prenom', $_POST['prenom']);
    $statement->bindParam(':note', $_POST['note']);
    $statement->bindParam(':prof', $_POST['id']);
    $statement->execute();

    header('Location: viewadmin.php');
}

function delEtu($db) {
    $sql = "DELETE FROM etudiant WHERE id = :student;";
    $statement = $db->prepare($sql);
    $statement->bindParam(':student', $_POST['id']);
    $statement->execute();
    header('Location: viewadmin.php');
}

function disconnect() {
    session_destroy();
}

?>