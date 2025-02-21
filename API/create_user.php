<?php
require_once(__DIR__ . '/../models/PDO.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$pseudo = $data['pseudo'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$email = $data['email'];
$name = $data['name'];
$birthdate = $data['birthdate'];


$sql = 'INSERT INTO user (pseudo, password, email, name, birthdate) VALUES (:pseudo, :password, :email, :name, :birthdate)';
$stmt = $PDO->prepare($sql);
$stmt->execute([
    'pseudo' => $pseudo,
    'password' => $password,
    'email' => $email,
    'name' => $name,
    'birthdate' => $birthdate
]);

echo json_encode(['message' => 'user created successfully']);

/*
/API/create_user.php

BODY:
{
    "pseudo" : "plop",
    "password" : "plop",
    "email" : "plop",
    "name" : "plop",
    "birthdate" : "2015-12-29"
}
*/