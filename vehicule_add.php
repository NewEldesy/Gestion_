<?php
include_once('model.php'); // Ensure model.php contains the dbConnect and addVehicule functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? null;

    if ($nom) {
        try {
            addVehicule(['nom' => $nom]);
            header("Location: vehicule.php?success=1");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Nom du véhicule est requis.";
    }
}