<?php
    include_once('model.php');
    
    if (isset($_POST['id']) && isset($_POST['id_produit']) && isset($_POST['quantite'])) {
        if (!empty($_POST['id']) && !empty($_POST['id_produit']) && !empty($_POST['quantite'])) {
            $data['id'] = (int)$_POST['id']; $data['id_produit'] = $_POST['id_produit']; $data['quantite'] = $_POST['quantite'];
            
            $maj = updateStock($data);
            if (!$maj) {
                echo '<div class="alert alert-success" role="alert">Informations Prestataires modifiée avec succès</div>
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