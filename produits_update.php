<?php
    include_once('model.php');
    
    if (isset($_POST['id']) && isset($_POST['designation']) && isset($_POST['vehicule']) && isset($_POST['pu'])) {
        if (!empty($_POST['id']) && !empty($_POST['designation']) && !empty($_POST['vehicule']) && !empty($_POST['pu'])) {
            $data['id'] = (int)$_POST['id']; $data['designation'] = $_POST['designation']; $data['vehicule'] = $_POST['vehicule']; $data['pu'] = $_POST['pu']; 
            $data['description'] = $_POST['description'];
            
            $maj = updateProduits($data);
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