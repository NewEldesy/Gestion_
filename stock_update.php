<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id'] = $_POST['id'] ?? null;
    $data['id_produit'] = $_POST['produit'] ?? null; $data['quantite'] = $_POST['quantite'] ?? null;

    // Validate the input
    if (!$data['id'] || !$data['id_produit'] || !$data['quantite']) {
        echo "All fields are required."; exit;
    }

    try {
        updateStock($data);
        header("Location: stock.php");
        exit;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>