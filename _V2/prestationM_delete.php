<?php
include("model.php");

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    if(!removePM($id)) {
        echo '<div class="alert alert-success" role="alert">Prestation supprimer avec succès !!!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Échec de la suppression de la prestation !!!</div>';
    }
}
?>