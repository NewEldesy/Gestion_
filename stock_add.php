<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id_produit'] = $_POST['produit'] ?? null;
    $data['quantite'] = $_POST['quantite'] ?? null;

    if ($data) {
        try {
            addStock($data);
            header("Location: stock.php");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}