<?php
    include_once('model.php');

    // : designation, vehicule: vehicule, : pu,:description
    if(isset($_POST['designation']) && isset($_POST['pu'])) {
        if(!empty($_POST['designation']) && !empty($_POST['pu'])) {
            $data['designation']=$_POST['designation']; $data['pu']=$_POST['pu'];
            $data['description']=$_POST['description']; $produit = addProduit($data);
            if(!$produit){
                echo '<div class="alert alert-success" role="alert">Produit ajoutée avec succès.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout du Produit.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Le champ est vide, veuillez remplir le nom du Produit.</div>';
    }