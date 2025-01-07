<?php
    header('Content-Type: application/json');
    include_once('model.php');
    $prestataires = getPrestataires();
    echo json_encode($prestataires);
?>