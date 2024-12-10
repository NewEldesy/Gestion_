<?php
    include_once('model.php');

    if(isset($_POST['nom'])) {
        if(!empty($_POST['nom'])) {
            $data['nom']=$_POST['nom'];
            $vehicule = addVehicule($data);
            if(!$vehicule){
                echo '<div class="alert alert-success" role="alert">Véhicule ajoutée avec succès.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout du Véhicule.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Le champ est vide, veuillez remplir le nom du Véhicule.</div>';
    }