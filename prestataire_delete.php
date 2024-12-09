<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removePrestataire($id)) {
        echo 'Prestataire supprimer avec succès.';
    } else {
        echo 'Échec de la suppression du prestataire.';
    }
}
?>