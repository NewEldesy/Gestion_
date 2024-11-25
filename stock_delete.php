<?php
include("model.php");

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if(!removeStock($id)) {
        header('Location: stock.php');
    } else {
        echo 'Échec de la suppression.';
    }
}
?>