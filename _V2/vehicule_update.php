<?php
    include_once('model.php');
    
    if (isset($_POST['id']) && isset($_POST['nom'])) {
        if (!empty($_POST['id']) && !empty($_POST['nom'])) {
            $data['id'] = (int)$_POST['id']; $data['nom'] = $_POST['nom'];
            
            $maj = updateVehicule($data);
            if (!$maj) {
                echo '<div class="alert alert-success" role="alert">Informations Vehicule modifiée avec succès</div>
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