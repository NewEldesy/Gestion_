<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id'] = $_POST['id'];
    $data['num_immatriculation'] = $_POST['immatriculation'] ?? null;
    $data['vehicule'] = $_POST['vehicule'] ?? null;
    $data['montant'] = $_POST['montant'] ?? null;
    $data['proprietaire_contact'] = $_POST['proprietaire_contact'] ?? null;
    $data['date_entree'] = $_POST['date_entree'] ?? null;
    $data['lieu_kilometrage'] = $_POST['lieu_kilometrage'] ?? null;
    $data['prestataire'] = $_POST['prestataire'] ?? null;
    $data['observation'] = $_POST['observation'] ?? null;
    // Validate the input
    if (!$data['id'] || !$data['num_immatriculation'] || !$data['vehicule'] || !$data['montant'] || !$data['proprietaire_contact'] 
        || !$data['date_entree'] || !$data['lieu_kilometrage'] || !$data['prestataire'] || !$data['observation']) {
        echo "All fields are required."; exit;
    }

    try {
        updatePT($data);
        header("Location: prestationT.php");
        exit;}
    catch (PDOException $e) { echo "Database error: " . $e->getMessage(); }
    catch (Exception $e) { echo "Error: " . $e->getMessage(); }
}
?>