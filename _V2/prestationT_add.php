<?php
include_once('model.php');

if(isset($_POST['num_immatriculation']) && isset($_POST['vehicule']) && isset($_POST['proprietaire_contact']) && isset($_POST['lieu_kilometrage']) && isset($_POST['date_entree']) && isset($_POST['montant']) && isset($_POST['prestataire'])) {
    if(!empty($_POST['num_immatriculation']) && !empty($_POST['vehicule']) && !empty($_POST['proprietaire_contact']) && !empty($_POST['lieu_kilometrage']) && !empty($_POST['date_entree']) && !empty($_POST['montant']) && !empty($_POST['prestataire'])) {
        $data['num_immatriculation']=$_POST['num_immatriculation']; $data['vehicule']=$_POST['vehicule']; $data['proprietaire_contact']=$_POST['proprietaire_contact'];
        $data['lieu_kilometrage']=$_POST['lieu_kilometrage']; $data['date_entree']=$_POST['date_entree']; $data['montant']=$_POST['montant'];
        $data['prestataire']=$_POST['prestataire']; $data['observation']=$_POST['observation'];
        $prestataire = addPT($data);
        if(!$prestataire){
            echo '<div class="alert alert-success" role="alert">Prestation ajoutée avec succès.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout du Prestation.</div>';
        }
    }
} else {
    echo '<div class="alert alert-warning" role="alert">Veuillez remplir les champs vide.</div>';
}