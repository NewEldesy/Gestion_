<?php
echo json_encode($_POST);
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;
    // Assurez-vous que $data est bien formaté
    if (isset($data['venteId']) && isset($data['remise']) && isset($data['total']) && isset($data['items']) && isset($data['statuts'])) {
        $transactionId = add_Prestation($data);
        echo '<div class="alert alert-success" role="alert">
                  Prestation enregistré avec succès</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                    Enregistrement échoué</div>';
    }
}