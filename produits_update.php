<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id'] = $_POST['id'] ?? null; $data['designation'] = $_POST['designation'] ?? null;
    $data['vehicule'] = $_POST['vehicule'] ?? null; $data['pu'] = $_POST['prixunitaire'] ?? null;
    $data['description'] = $_POST['description'];
    // Validate the input
    if (!$data['id'] || !$data['designation'] || !$data['vehicule'] || !$data['pu']) {
        echo "All fields are required."; exit;
    }

    try {
        updateProduits($data);
        header("Location: produits.php");
        exit;}
    catch (PDOException $e) { echo "Database error: " . $e->getMessage(); }
    catch (Exception $e) { echo "Error: " . $e->getMessage(); }
}
?>