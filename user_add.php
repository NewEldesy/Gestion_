<?php
    include_once('model.php');
    
    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['username'])) {
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['username'])) {
            $data['nom']=$_POST['nom']; $data['prenom']=$_POST['prenom'];
            $data['username']=$_POST['username']; $user = addUser($data);
            if(!$user){
                echo '<div class="alert alert-success" role="alert">Utilisateur ajoutée avec succès.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout du Utilisateur.</div>';
            }
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Le champ est vide, veuillez remplir le nom du Utilisateur.</div>';
    }