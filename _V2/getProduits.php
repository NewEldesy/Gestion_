<?php
    header('Content-Type: application/json'); // header pour spécifier que la réponse est en JSON
    include_once('model.php');
    $produits = getProducts(); // Appeler la fonction getProducts() pour récupérer les produits de la catégorie spécifiée
    echo json_encode($produits); // Renvoi des produits sous forme de JSON
?>