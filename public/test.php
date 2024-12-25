<?php


require_once '../config/config.php';

$db = getDBConnection();

$stmt = $db->prepare('SELECT * FROM notas');
$stmt->execute();
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($notas);
echo "</pre>";


