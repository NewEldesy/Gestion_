<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $designation = $_POST['designation'] ?? null;
    $vehicule = $_POST['vehicule'] ?? null;
    $pu = $_POST['pu'] ?? null;
    $description = $_POST['description'];

    if ($designation || $vehicule || $pu) {
        try {
            addProduit([
                'designation' => $designation,
                'vehicule' => $vehicule,
                'pu' => $pu,
                'description' => $description
            ]);
            header("Location: produits.php");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}