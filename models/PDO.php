<?php
$host = '';
$db   = '';
$user = '';
$pass = '';

//Traitement des erreurs à la connexion de la BDD
try {
    $PDO = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    /* Decocher puis lancer le fichier pour la création de la bdd
    // Chemin vers le fichier SQL
    $sqlFile = 'db_init.sql';
    // Lecture du contenu du fichier SQL
    $sql = file_get_contents($sqlFile);
    // Exécution du script SQL
    $PDO->exec($sql);
    */
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
