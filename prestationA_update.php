<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id'] = $_POST['id'];
    $data['num_immatriculation'] = $_POST['num_immatriculation'] ?? null;
    $data['vehicule'] = $_POST['vehicule'] ?? null;
    $data['contact_proprietaire'] = $_POST['contact_proprietaire'] ?? null;
    $data['type_prestation'] = $_POST['type_prestation'] ?? null;
    $data['montant'] = $_POST['montant'] ?? null;
    $data['date_entree'] = $_POST['date_entree'] ?? null;
    $data['prestataire'] = $_POST['prestataire'] ?? null;
    $data['observation'] = $_POST['observation'] ?? null;
    // Validate the input
    if (!$data['id'] || !$data['num_immatriculation'] || !$data['vehicule'] || !$data['montant'] || !$data['contact_proprietaire'] 
        || !$data['date_entree'] || !$data['type_prestation'] || !$data['prestataire'] || !$data['observation']) {
        echo "All fields are required."; exit;
    }

    try {
        updatePA($data);
        header("Location: prestationA.php");
        exit;}
    catch (PDOException $e) { echo "Database error: " . $e->getMessage(); }
    catch (Exception $e) { echo "Error: " . $e->getMessage(); }
}
?>