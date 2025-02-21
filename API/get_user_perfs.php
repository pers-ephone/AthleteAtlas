<?php

require_once(__DIR__ . '/../models/PDO.php');
header('Content-Type: application/json');

$id_user = $_GET['id_user'];

$sql = 'SELECT distance, duree, average_speed, sport FROM performance WHERE id_user = :id_user';
$stmt = $PDO->prepare($sql);
$stmt->execute(['id_user' => $id_user]);
$perfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($perfs);

// /API/get_user_perfs.php?id_user=1