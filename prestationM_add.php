<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_immatriculation = $_POST['immatriculation'] ?? null;
    $vehicule = $_POST['vehicule'] ?? null;
    $montant = $_POST['montant'] ?? null;
    $proprietaire_contact = $_POST['proprietaire_contact'] ?? null;
    $date_entree = $_POST['date_entree'] ?? null;
    $date_sortie = $_POST['date_sortie'] ?? null;
    $prestataire = $_POST['prestataire'] ?? null;
    $observation = $_POST['observation'] ?? null;

    if ($num_immatriculation || $vehicule || $montant || $proprietaire_contact || $date_entree || $date_sortie || $prestataire || $observation) {
        try {
            addPM([
                'num_immatriculation' => $num_immatriculation,
                'vehicule' => $vehicule,
                'montant' => $montant,
                'proprietaire_contact' => $proprietaire_contact,
                'date_entree' => $date_entree,
                'date_sortie' => $date_sortie,
                'prestataire' => $prestataire,
                'observation' => $observation
            ]);
            header("Location: prestationM.php");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}