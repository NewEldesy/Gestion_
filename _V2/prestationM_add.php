<?php
include_once('model.php');

if(isset($_POST['num_immatriculation']) && isset($_POST['vehicule']) && isset($_POST['montant']) && isset($_POST['proprietaire_contact']) && isset($_POST['date_entree']) && isset($_POST['date_sortie']) && isset($_POST['prestataire'])) {
    if(!empty($_POST['num_immatriculation']) && !empty($_POST['vehicule']) && !empty($_POST['montant']) && !empty($_POST['proprietaire_contact']) && !empty($_POST['date_entree']) && !empty($_POST['date_sortie']) && !empty($_POST['prestataire'])) {
        $data['num_immatriculation']=$_POST['num_immatriculation']; $data['vehicule']=$_POST['vehicule']; $data['montant']=$_POST['montant'];
        $data['proprietaire_contact']=$_POST['proprietaire_contact']; $data['date_entree']=$_POST['date_entree']; $data['date_sortie']=$_POST['date_sortie'];
        $data['prestataire']=$_POST['prestataire']; $data['observation']=$_POST['observation'];
        $prestataire = addPM($data);
        if(!$prestataire){
            echo '<div class="alert alert-success" role="alert">Prestation ajoutée avec succès.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Échec de l\'ajout du Prestation.</div>';
        }
    }
} else {
    echo '<div class="alert alert-warning" role="alert">Veuillez remplir les champs vide.</div>';
}