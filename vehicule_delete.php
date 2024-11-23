<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removeVehicule($id)) {
        header('Location: vehicule.php');
    } else {
        echo 'Échec de la suppression du vehicule.';
    }
}
?>