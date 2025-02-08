<?php
    include_once('model.php');
    
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['username'])) {
        if (!empty($_POST['id']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['username'])) {
            $data = [
                'id' => (int)$_POST['id'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'username' => $_POST['username']
            ];

            if (isset($_POST['password']) && !empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }
            
            $maj = updateUser($data);
            // var_dump($maj); exit;
            if (!$maj) {
                echo '<div class="alert alert-success" role="alert">Informations Utilisateur modifiée avec succès</div>
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