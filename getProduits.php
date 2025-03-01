<?php
    header('Content-Type: application/json');
    include_once('model.php');
    $produits = getProducts();
    echo json_encode($produits);
?>