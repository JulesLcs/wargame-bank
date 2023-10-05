<?php
include 'connexpdo.php';
//=========================== connection bdd ===============================================

$bd = connexpdo("etudiants", "postgres", "Isen2018");
$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function ajout_new_utilisateur(){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    $nom = $_POST['fname'];
    $prenom = $_POST['name'];
    $mail = $_POST['mail'];
    $login = $_POST['login'];
    $password = $_POST['password'];
      echo "<h1>ICI</h1>";
    
//==========================================================================================

    if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($login) && !empty($password)) {
        //========================================= creation bool pour verification ===========================
        $login_existe = false;
        $nom_existe = false;
        $prenom_existe = false;
        //==================================  verification du login =============================

        $query = "SELECT * from etudiant";
        $sth = $bd->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();
        var_dump($result);
        if (!empty($result)){
            echo "<script>alert('ce login existe deja veuillez en choisir un autre')</script>";
            $login_existe =true;
        }




//==================================== verification du nom et prenom ==========================

        $query = "select nom,prenom from utilisateur;";
        $sth = $bd->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();
        var_dump($result);
        foreach ($login as $val) {
            if ($val[0] == $login) {
                if ($val[1] == $login) {
                    echo "<script>alert('ce login existe deja veuillez en choisir un autre')</script>";
                    $login_existe = true;
                }
            }
        }
    }
}
function edit_etudiant($id_etudiant){};
function ajout_new_etudian($nom, $prenom, $note){};
function connection($login, $assword){};

