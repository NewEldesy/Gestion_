<?php
require_once 'model.php';

try { // Connexion à la base de données
    $db = dbConnect();

    // Requête SQL pour récupérer les données
    $sql = "SELECT date_fin FROM licence_active WHERE status = 'active'";
    $result = $db->prepare($sql); $result->execute();
    $data = [];
    // Récupérer les données et les stocker dans un tableau
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    // Renvoyer les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // En cas d'erreur, renvoyer un message d'erreur
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erreur de base de données : ' . $e->getMessage()]);
} finally { // Fermer la connexion
    $db = null;
}
?>