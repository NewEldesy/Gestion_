<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_immatriculation = $_POST['num_immatriculation'] ?? null;
    $vehicule = $_POST['vehicule'] ?? null;
    $contact_proprietaire = $_POST['contact_proprietaire'] ?? null;
    $type_prestation = $_POST['type_prestation'] ?? null;
    $montant = $_POST['montant'] ?? null;
    $date_entree = $_POST['date_entree'] ?? null;
    $prestataire = $_POST['prestataire'] ?? null;
    $observation = $_POST['observation'] ?? null;

    if ($num_immatriculation || $vehicule || $contact_proprietaire || $type_prestation   || $montant|| $date_entree|| $prestataire || $observation) {
        try {
            addPA([
                'num_immatriculation' => $num_immatriculation,
                'vehicule' => $vehicule,
                'contact_proprietaire' => $contact_proprietaire,
                'type_prestation' => $type_prestation,
                'montant' => $montant,
                'date_entree' => $date_entree,
                'prestataire' => $prestataire,
                'observation' => $observation
            ]);
            header("Location: prestationA.php");
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}