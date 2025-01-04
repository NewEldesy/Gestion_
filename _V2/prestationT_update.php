<?php
include_once('model.php');

if (isset($_POST['id']) && isset($_POST['num_immatriculation']) && isset($_POST['vehicule']) && isset($_POST['proprietaire_contact']) && isset($_POST['lieu_kilometrage']) && isset($_POST['date_entree']) && isset($_POST['montant']) && isset($_POST['prestataire'])) {
    if (!empty($_POST['id']) && !empty($_POST['num_immatriculation']) && !empty($_POST['vehicule']) && !empty($_POST['proprietaire_contact']) && !empty($_POST['lieu_kilometrage']) && !empty($_POST['date_entree']) && !empty($_POST['montant']) && !empty($_POST['prestataire'])) {
        $data['id'] = (int)$_POST['id']; $data['num_immatriculation'] = $_POST['num_immatriculation']; $data['vehicule'] = $_POST['vehicule']; $data['proprietaire_contact'] = $_POST['proprietaire_contact'];
        $data['lieu_kilometrage'] = $_POST['lieu_kilometrage']; $data['date_entree'] = $_POST['date_entree']; $data['montant'] = $_POST['montant'];
        $data['prestataire'] = $_POST['prestataire']; $data['observation'] = $_POST['observation'];
        
        $maj = updatePT($data);
        if (!$maj) {
            echo '<div class="alert alert-success" role="alert">Informations Produit modifiée avec succès</div>
            <script>$("#exampleModalMaj").modal("hide")</script>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Échec de la modification</div>';
        }
    } else {
        echo '<div class="alert alert-warning" role="alert">Veuillez remplir tous les champs.</div>';
    }
} else {
    echo '<div class="alert alert-warning" role="alert">Données manquantes pour la mise à jour.</div>';
}