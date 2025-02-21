<?php
require_once(__DIR__ . '/../models/PDO.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$distance = $data['distance'];
$duree = $data['duree'];
$average_speed = $data['average_speed'];
$sport = $data['sport'];
$id_user = $data['id_user'];


$sql = 'INSERT INTO performance (distance, duree, average_speed, sport, id_user) VALUES (:distance, :duree, :average_speed, :sport, :id_user)';
$stmt = $PDO->prepare($sql);
$stmt->execute([
    'distance' => $distance,
    'duree' => $duree,
    'average_speed' => $average_speed,
    'sport' => $sport,
    'id_user' => $id_user
]);

echo json_encode(['message' => 'performance added successfully']);

/*
/API/create_perf.php

BODY:
{
    "distance" : "",
    "duree" : "",
    "average_speed" : "",
    "sport" : "plop",
    "id_user" : "123"
}
*/