<?php
    header('Content-Type: application/json');
    include_once('model.php');

    $produits = getProducts();
    // var_dump($produits); exit;
    echo json_encode($produits);
?>