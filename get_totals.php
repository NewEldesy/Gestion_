<?php
require_once 'model.php';
$totals = getTransactionTotals();

// Retourner les totaux en JSON
header('Content-Type: application/json');
echo json_encode($totals);
?>