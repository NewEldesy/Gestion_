<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removePT($id)) {
        header('Location: prestationT.php');
    } else {
        echo 'Échec de la suppression de la prestation de Tractage.';
    }
}
?>