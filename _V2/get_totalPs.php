<?php
require_once 'model.php';
$totals = getPrestationTotals();

// Retourner les totaux en JSON
header('Content-Type: application/json');
echo json_encode($totals);
?>