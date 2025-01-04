<?php
include 'model.php'; // Connexion à la base de données

$data['lastId'] = getIdVente() + 1;

echo json_encode(['lastId' => $data['lastId'] ?? 0]);
?>