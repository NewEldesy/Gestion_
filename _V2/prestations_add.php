<?php
    include_once('model.php');
    
    if(isset($_POST['designation']) && isset($_POST['prix'])) {
        if(!empty($_POST['designation']) && !empty($_POST['prix'])) {
            $data['designation']=$_POST['designation']; $data['prix']=$_POST['prix'];
            $data['description']=$_POST['description'];
            $prestation = addPrestation($data);
            if(!$prestation){
                echo '<div class="alert alert-success" role="alert">Prestation ajoutée avec succès.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout de la Prestation.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Le champ est vide, veuillez remplir le nom de la Prestation.</div>';
    }