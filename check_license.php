<?php
include_once('model.php');
session_start();

// Connexion à la base de données
$db = dbConnect();
// Vérifier la dernière licence active
$stmt = $db->prepare("SELECT la.date_fin, l.numero_licence FROM licence_active la JOIN licence l ON la.id_licence = l.id 
                      WHERE la.status = 'active' ORDER BY la.id DESC LIMIT 1");
$stmt->execute(); $license = $stmt->fetch(PDO::FETCH_ASSOC);

if ($license) {
    if ($license['date_fin'] >= date('Y-m-d')) {
        echo json_encode(['status' => 'valid']);
    } else {
        // Mettre à jour le statut si la licence expire aujourd'hui
        $stmt2 = $db->prepare("UPDATE licence_active SET status = 'inactive' WHERE id = :id");
        $stmt2->bindParam(':id', $license['id']);
        $stmt2->execute();
        echo json_encode(['status' => 'expired']);
    }
} else {
    echo json_encode(['status' => 'no_license']);
}
?>