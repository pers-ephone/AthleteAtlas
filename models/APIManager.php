<?php
include "PDO.php";

function VerifUser($email, $password)
{

    global $PDO;

    $sqlQuery = 'SELECT password, id_user FROM user WHERE email = :email';
    $pdo_prepare = $PDO->prepare($sqlQuery);
    $pdo_prepare->execute(['email' => $email]);
    $response = $pdo_prepare->fetch();

    if (isset($response['password']) && password_verify($password, $response['password'])) {
        echo $response['id_user'];
    } else {
        echo '-1';
    }
    /*
    En local : web?action=verifuserapi&email=florentcabassut@gmail.com&password=azertyuiop
    Via le site web en ligne : https://athleteatlas.alwaysdata.net/?action=verifuserapi&email=florentcabassut@gmail.com&password=azertyuiop

    */
}

function GetUserPerformance($id_user)
{

    global $PDO;

    $sql = 'SELECT distance, duree, average_speed, sport FROM performance WHERE id_user = :id_user';
    $stmt = $PDO->prepare($sql);
    $stmt->execute(['id_user' => $id_user]);
    $perfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return json_encode($perfs);

    /* 
    En local : http://localhost:8000/web?action=getuserperfapi&id_user=10
    Via le site web en ligne : https://athleteatlas.alwaysdata.net/?action=getuserperfapi&id_user=8

    */
}

function CreateUser($pseudo, $password, $email, $name, $birthdate)
{

    global $PDO;
    $sql = 'INSERT INTO user (pseudo, password, email, name, birthdate) VALUES (:pseudo, :password, :email, :name, :birthdate)';
    $stmt = $PDO->prepare($sql);
    $stmt->execute([
        'pseudo' => $pseudo,
        'password' => $password,
        'email' => $email,
        'name' => $name,
        'birthdate' => $birthdate
    ]);

    return json_encode(['message' => 'user created successfully']);
    /*

    En local : /web?action=createuserapi
    Via le site web en ligne : https://athleteatlas.alwaysdata.net/?action=createuserapi
    BODY:
    {
        "pseudo" : "plop",
        "password" : "plop",
        "email" : "plop",
        "name" : "plop",
        "birthdate" : "2015-12-29"
    }
    */
}

function CreatePerf($distance, $duree, $average_speed, $sport, $id_user)
{

    global $PDO;

    $sql = 'INSERT INTO performance (distance, duree, average_speed, sport, id_user) VALUES (:distance, :duree, :average_speed, :sport, :id_user)';
    $stmt = $PDO->prepare($sql);
    $stmt->execute([
        'distance' => $distance,
        'duree' => $duree,
        'average_speed' => $average_speed,
        'sport' => $sport,
        'id_user' => $id_user
    ]);

    return json_encode(['message' => 'performance added successfully']);

    /*
    En local : /web?action=createperfapi
    Via le site web en ligne : https://athleteatlas.alwaysdata.net/?action=createperfapi
    BODY: 
    {

        "distance": 110.00,
        "duree": "02:00:00",
        "sport": "Velo",
        "id_user": 12
        
    }
    */
}
