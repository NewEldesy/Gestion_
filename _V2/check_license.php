<?php
include_once('model.php');
session_start();

// Connexion à la base de données
$db = dbConnect();
// Préparer la requête SQL pour récupérer la dernière licence enregistrée
$stmt = $db->prepare("SELECT * FROM Licence_active WHERE status = 'active' ORDER BY id DESC LIMIT 1");
$stmt->execute();
$license = $stmt->fetch(PDO::FETCH_ASSOC);

if ($license) {
    // Vérifier si la licence est valide
    if ($license['date_fin'] >= date('Y-m-d')) {
        echo json_encode(['status' => 'valid']);
    } elseif ($license['date_fin'] == date('Y-m-d')) {
        // Mettre à jour le statut si la licence expire aujourd'hui
        $stmt2 = $db->prepare("UPDATE Licence_active SET status = 'expired' WHERE id = :id");
        $stmt2->bindParam(':id', $license['id']);
        $stmt2->execute(); echo json_encode(['status' => 'expired']);
    }
}
 else {
    echo json_encode(['status' => 'no_license']);
}
?>