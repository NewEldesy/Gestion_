<?php
include 'model.php'; // Connexion à la base de données

foreach(getVehicule() as $row) {
    $vehicules[] = [
        'id' => $row['id'],
        'nom' => $row['nom']
    ];
}

echo json_encode($vehicules);
?>