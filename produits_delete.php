<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removeProduits($id)) {
        header('Location: produits.php');
    } else {
        echo 'Échec de la suppression du produit.';
    }
}
?>