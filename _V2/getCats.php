<?php
    header('Content-Type: application/json');
    include_once('model.php');

    $cats = getCats();
    echo json_encode($cats);
?>