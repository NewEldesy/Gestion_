<?php
include_once('model.php');
session_start();

// Vérifier si la licence est envoyée via POST
if (isset($_POST['licence']) && !empty($_POST['licence'])) {
    $licence = $_POST['licence'];

    // Hasher la licence pour la comparer avec celle dans la base de données
    $hashedLicence = hash('sha256', $licence);

    // Connexion à la base de données
    $db = dbConnect();

    try {
        // Vérifier si la licence existe et n'est pas utilisée
        $stmt = $db->prepare("SELECT id, duree FROM licence WHERE numero_licence = :numero_licence AND statuts = 'non utilisé'");
        $stmt->bindParam(':numero_licence', $hashedLicence);
        $stmt->execute();
        $licenceData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($licenceData) {
            // Calculer la date d'expiration
            $dateFin = date('Y-m-d', strtotime("+" . $licenceData['duree'] . " days"));

            // Activer la licence
            $stmt2 = $db->prepare("INSERT INTO licence_active (id_licence, date_fin, status) VALUES (:id_licence, :date_fin, 'active')");
            $stmt2->bindParam(':id_licence', $licenceData['id']);
            $stmt2->bindParam(':date_fin', $dateFin);
            $stmt2->execute();

            // Mettre à jour le statut de la licence dans la table `licence`
            $stmt3 = $db->prepare("UPDATE licence SET statuts = 'utilisé' WHERE id = :id");
            $stmt3->bindParam(':id', $licenceData['id']);
            $stmt3->execute();

            // Réponse JSON en cas de succès
            echo json_encode(['status' => 'success', 'message' => 'Licence activée avec succès.']);
        } else {
            // Réponse JSON si la licence est invalide ou déjà utilisée
            echo json_encode(['status' => 'error', 'message' => 'Licence invalide ou déjà utilisée.']);
        }
    } catch (PDOException $e) {
        // Réponse JSON en cas d'erreur de base de données
        echo json_encode(['status' => 'error', 'message' => 'Erreur de base de données : ' . $e->getMessage()]);
    } finally {
        // Fermer la connexion à la base de données
        $db = null;
    }
} else {
    // Réponse JSON si la licence n'est pas fournie
    echo json_encode(['status' => 'error', 'message' => 'Veuillez fournir une licence.']);
}
?>