<?php
include("model.php");

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    if(!removeVehicule($id)) {
        echo 'Véhicule supprimer avec succès !!!';
    } else {
        echo 'Échec de la suppression du vehicule !!!';
    }
}
?>