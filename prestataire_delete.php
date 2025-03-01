<?php
include("model.php");

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    if(!removePrestataire($id)) {
        echo '<div class="alert alert-success" role="alert">Prestataire supprimer avec succès !!!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Échec de la suppression du prestataire !!!</div>';
    }
}
?>