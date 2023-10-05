<?php
function connexpdo($base, $user, $password){
    $dsn = "pgsql:dbname=".$base.";host=127.0.0.1;port=5432";

    try {
        $dbh = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        return 0;
    }
    return $dbh;
}
?>