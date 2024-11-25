<?php
include_once('model.php');
// var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id'] = $_POST['id'] ?? null; $data['nom'] = $_POST['nom'] ?? null;
    $data['prenom'] = $_POST['prenom'] ?? null; $data['poste'] = $_POST['poste'] ?? null;
    $data['date_naissance'] = $_POST['date_naissance'] ?? null;
    $data['telephone'] = $_POST['telephone'] ?? null; $data['telephone2'] = $_POST['telephone2'];
    // Validate the input
    if (!$data['id'] || !$data['nom'] || !$data['prenom'] || !$data['date_naissance'] || !$data['telephone'] || !$data['poste']) {
        echo "All fields are required."; exit;
    }

    try {
        updatePrestataire($data);
        header("Location: prestataire.php");
        exit;}
    catch (PDOException $e) { echo "Database error: " . $e->getMessage(); }
    catch (Exception $e) { echo "Error: " . $e->getMessage(); }
}
?>