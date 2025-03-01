<?php
include("model.php");

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    if(!removeVehicule($id)) {
        echo '<div class="alert alert-success" role="alert">Véhicule supprimer avec succès !!!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Échec de la suppression du vehicule !!!</div>';
    }
}
?>