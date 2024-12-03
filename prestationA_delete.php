<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removePA($id)) {
        header('Location: prestationA.php');
    } else {
        echo 'Échec de la suppression du prestataire.';
    }
}
?>