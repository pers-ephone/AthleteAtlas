<?php
include "../models/PDO.php";

function DisplayActivity(int $id_user, string $select)
{
    global $PDO;

    // Order by permet de récup la derniere donnée
    $sql_sports = 'SELECT ' . $select . ' FROM performance WHERE id_user = :id_user ORDER BY id_performance DESC LIMIT 1';
    $pdo_prepare_sport = $PDO->prepare($sql_sports);
    $pdo_prepare_sport->execute(['id_user' => $id_user]);
    $user = $pdo_prepare_sport->fetch();

    // Vérifier si une activité a été trouvée
    if ($user) {
        return $user[$select];
    } else {
        // Retourner une valeur par défaut ou un message si aucune activité n'a été trouvée
        return 'Aucune activité trouvée';
    }
}
/*
function AverageSpeed(int $id_user, int $id_performance)
{
    global $PDO;

    $sql_sports = 'SELECT distance, TIME_TO_SEC(duree) AS duree_sec FROM performance WHERE id_user = :id_user AND id_performance = :id_performance ORDER BY id_performance';
    $pdo_prepare_sport = $PDO->prepare($sql_sports);
    $pdo_prepare_sport->execute(['id_user' => $id_user, 'id_performance' => $id_performance]);
    $user = $pdo_prepare_sport->fetch();

    if ($user) {
        $distance = $user['distance'];
        $duree = $user['duree_sec'];

        $vitesse = ($distance / $duree) * 3600;
        // Limite à 2 aprés la virgule
        return number_format($vitesse, 2);
    }
    return null;
}

function AverageSpeedLastSport(int $id_user)
{
    global $PDO;

    $sql_sports = 'SELECT distance, TIME_TO_SEC(duree) AS duree_sec FROM performance WHERE id_user = :id_user ORDER BY id_performance DESC LIMIT 1';
    $pdo_prepare_sport = $PDO->prepare($sql_sports);
    $pdo_prepare_sport->execute(['id_user' => $id_user]);
    $user = $pdo_prepare_sport->fetch();

    if ($user) {
        $distance = $user['distance'];
        $duree = $user['duree_sec'];

        $vitesse = ($distance / $duree) * 3600;
        // Limite à 2 aprés la virgule
        return number_format($vitesse, 2);
    }
    return null;
}
    */

function TotalStat(string $select, string $sport)
{
    global $PDO;
    $id_user = $_SESSION['id_user'];

    $sql_sports = 'SELECT ' . $select . ' FROM performance WHERE id_user = :id_user AND sport = :sport';
    $pdo_prepare_sport = $PDO->prepare($sql_sports);
    $pdo_prepare_sport->execute(['id_user' => $id_user, 'sport' => $sport]);

    $total = 0;
    $total_activite = 0;
    // Boucle pour récuperer l'ensemble du tableau
    // condition pour savoir si on souhaite récup le nombre de fois ou est affiché un sport
    while ($user = $pdo_prepare_sport->fetch()) {
        if ($select == "sport") {
            $total_activite++;
        } else {
            $distance = $user[$select];
            $total += $distance;
        }
    }
    echo $total;
    if ($total_activite != 0) {
        echo $total_activite;
    }
}

function DisplayAllUserActivity($id_user)
{
    global $PDO;
    $sql_sports = 'SELECT * FROM performance WHERE id_user = :id_user ORDER BY id_performance DESC';
    $pdo_prepare_sport = $PDO->prepare($sql_sports);
    $pdo_prepare_sport->execute(['id_user' => $id_user]);

    return $pdo_prepare_sport->fetchall();
}

function DisplaySport($order_by, $sport)
{

    global $PDO;

    $sql_sports =   'SELECT performance.*, user.pseudo
                    FROM performance
                    INNER JOIN user ON performance.id_user = user.id_user
                    WHERE performance.sport = :sport
                    ORDER BY ' . $order_by . ' DESC';

    $pdo_prepare_sport = $PDO->prepare($sql_sports);
    $pdo_prepare_sport->execute([':sport' => $sport]);

    return $pdo_prepare_sport->fetchall();
}

function DisplayPseudoForAdmin()
{

    global $PDO;
    // On ne souhaite pas afficher le pseudo de l'admin qui a dans ma bdd l'id 3
    $sql_pseudo = 'SELECT * FROM user EXCEPT SELECT * FROM user WHERE is_admin = 1';
    $pdo_prepare_pseudo = $PDO->prepare($sql_pseudo);
    $pdo_prepare_pseudo->execute();

    return $pdo_prepare_pseudo->fetchAll();
}
