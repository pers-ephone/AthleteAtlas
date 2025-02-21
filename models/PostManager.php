<?php

include "../models/PDO.php";

function PostActivity($id_user, $sport_name,  $distance, $timeString, $vitesse_formate)
{
    global $PDO;

    $sql = "INSERT INTO performance (distance, duree, sport, id_user, average_speed) VALUES (:distance, :timeString, :sport, :id_user, :average_speed)";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_execute = $pdo_prepare->execute(['distance' => $distance, 'timeString' => $timeString, 'sport' => $sport_name, 'id_user' => $id_user, 'average_speed' => $vitesse_formate]);

    return $pdo_execute;
}

function ModifyCommentaryByAdmin($content, $id_post)
{
    global $PDO;
    $sql = "UPDATE post SET content = :content WHERE id_post = :id_post";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_execute = $pdo_prepare->execute([':content' => $content, ':id_post' => $id_post]);

    return $pdo_execute;
}

function SuppresCommentaryByAdmin($id_post)
{
    global $PDO;
    $sql = "DELETE FROM post WHERE id_post = :id_post";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_execute = $pdo_prepare->execute([':id_post' => $id_post]);
    return $pdo_execute;
}

function UpdateProfile($name, $email, $pseudo, $id_user)
{
    global $PDO;
    $sql = "UPDATE user SET name = :name, email = :email, pseudo = :pseudo WHERE id_user = :id_user";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_execute = $pdo_prepare->execute(['name' => $name, 'email' => $email, 'pseudo' => $pseudo, 'id_user' => $id_user]);

    return $pdo_execute;
}

function updateUserResetToken($id_user, $reset_token)
{
    global $PDO;

    $sql = 'UPDATE user SET reset_token = :reset_token WHERE id_user = :user';
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_execute = $pdo_prepare->execute(['reset_token' => $reset_token, 'user' => $id_user]);

    return $pdo_execute;
}

function updatePassword($id_user, $password)
{
    global $PDO;

    $sqlQuery = 'UPDATE user SET password = :password WHERE id_user = :id_user';
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['password' => $password, 'id_user' => $id_user]);

    return true;
}

function updateUserActivity($sport, $distance, $duree, $average_speed, $id_performance)
{

    global $PDO;

    $sql = "UPDATE performance SET sport = :sport, distance = :distance, duree = :duree, average_speed = :average_speed WHERE id_performance = :id_performance";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_prepare->execute(['sport' => $sport, 'distance' => $distance, 'duree' => $duree, 'average_speed' => $average_speed, 'id_performance' => $id_performance]);

    return true;
}

function SuppressCommentary($id_performance)
{

    global $PDO;

    $sql = "DELETE FROM performance WHERE id_performance = :id_performance";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_prepare->execute(['id_performance' => $id_performance]);

    return true;
}

function DeletePseudoByAdmin($id_user)
{

    global $PDO;

    $sql = "DELETE FROM user WHERE id_user = :id_user";
    $pdo_prepare = $PDO->prepare($sql);
    $pdo_execute = $pdo_prepare->execute(['id_user' => $id_user]);

    return true;
}
