<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $date_naissance = $_POST['date_naissance'] ?? null;
    $telephone = $_POST['telephone'] ?? null;
    $telephone2 = $_POST['telephone2'];
    $poste = $_POST['poste'] ?? null;

    if ($nom || $prenom || $date_naissance || $telephone || $poste) {
        try {
            addPrestataire([
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $date_naissance,
                'telephone' => $telephone,
                'telephone2' => $telephone2,
                'poste' => $poste
            ]);
            header("Location: prestataire.php");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}