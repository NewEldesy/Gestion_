<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_immatriculation = $_POST['immatriculation'] ?? null;
    $vehicule = $_POST['vehicule'] ?? null;
    $montant = $_POST['montant'] ?? null;
    $proprietaire_contact = $_POST['proprietaire_contact'] ?? null;
    $date_entree = $_POST['date_entree'] ?? null;
    $lieu_kilometrage = $_POST['lieu_kilometrage'] ?? null;
    $prestataire = $_POST['prestataire'] ?? null;
    $observation = $_POST['observation'] ?? null;

    if ($num_immatriculation || $vehicule || $montant || $proprietaire_contact || $date_entree || $lieu_kilometrage || $prestataire || $observation) {
        try {
            addPT([
                'num_immatriculation' => $num_immatriculation,
                'vehicule' => $vehicule,
                'montant' => $montant,
                'proprietaire_contact' => $proprietaire_contact,
                'date_entree' => $date_entree,
                'lieu_kilometrage' => $lieu_kilometrage,
                'prestataire' => $prestataire,
                'observation' => $observation
            ]);
            header("Location: prestationT.php");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}