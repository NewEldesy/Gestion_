<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removePM($id)) {
        header('Location: prestationM.php');
    } else {
        echo 'Échec de la suppression du prestataire.';
    }
}
?>