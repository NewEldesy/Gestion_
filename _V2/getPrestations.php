<?php
    header('Content-Type: application/json');
    include_once('model.php');
    $prestations = getPrestations();
    echo json_encode($prestations);
?>