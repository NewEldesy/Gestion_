<?php
include_once('model.php');

if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['telephone']) && isset($_POST['poste'])) {
    if (!empty($_POST['id']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date_naissance']) && !empty($_POST['telephone']) && !empty($_POST['poste'])) {
        $data['id'] = (int)$_POST['id']; $data['nom'] = $_POST['nom']; $data['prenom'] = $_POST['prenom']; $data['date_naissance'] = $_POST['date_naissance'];
        $data['telephone'] = $_POST['telephone']; $data['telephone2'] = $_POST['telephone2']; $data['poste'] = $_POST['poste'];
        
        $maj = updatePrestataire($data);
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