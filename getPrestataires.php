<?php
    header('Content-Type: application/json');
    include_once('model.php');
    $prestataires = getPrestataire();
    echo json_encode($prestataires);
?>