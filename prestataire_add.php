<?php
    include_once('model.php');

    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['telephone']) && isset($_POST['poste'])) {
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date_naissance']) && !empty($_POST['telephone']) && !empty($_POST['poste'])) {
            $data['nom']=$_POST['nom']; $data['prenom']=$_POST['prenom']; $data['date_naissance']=$_POST['date_naissance'];
            $data['telephone']=$_POST['telephone']; $data['telephone2']=$_POST['telephone2']; $data['poste']=$_POST['poste'];
            $prestataire = addPrestataire($data);
            if(!$prestataire){
                echo '<div class="alert alert-success" role="alert">Prestataire ajoutée avec succès.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout du Prestataire.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Le champ est vide, veuillez remplir le nom du Prestataire.</div>';
    }