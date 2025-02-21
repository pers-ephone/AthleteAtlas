<?php

require_once(__DIR__ . '/../models/PDO.php');
header('Content-Type: text/plain');

$email = $_GET['email'];
$password = $_GET['password'];

$sqlQuery = 'SELECT password, id_user FROM user WHERE email = :email';
$pdo_prepare = $PDO->prepare($sqlQuery);
$pdo_prepare->execute(['email' => $email]);
$response = $pdo_prepare->fetch();

if (isset($response['password']) && password_verify($password, $response['password'])) {
    echo $response['id_user'];
} else {
    echo '-1';
}

// /API/verif_user.php?email=plop&password=plop