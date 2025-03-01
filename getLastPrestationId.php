<?php
include 'model.php';
$data['lastId'] = getIdPrestation() + 1;
echo json_encode(['lastId' => $data['lastId'] ?? 0]);
?>