<?php
function dbConnect() {
    try {
        $database = new PDO('sqlite:BDD/Gestion.db');
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
    } catch (PDOException $e) {
        handleDatabaseError($e->getMessage());
    }
}
function handleDatabaseError($errorMessage) {
    exit("Erreur de base de données : " . $errorMessage);
}
function deleteRecord($table, $idColumn, $id) { // Fonctions pour supprimer un enregistrement d'une table spécifique
    $database = dbConnect();
    $stmt = $database->prepare("DELETE FROM {$table} WHERE {$idColumn} = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); $stmt->execute();
}
function getById($table, $idColumn, $id) { // Fonctions pour obtenir un enregistrement par ID à partir d'une table spécifique
    $database = dbConnect();
    $stmt = $database->prepare("SELECT * FROM {$table} WHERE {$idColumn} = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Vehicule function
function addVehicule($data) {
    if (!is_array($data) || !isset($data['nom'])) {
        throw new InvalidArgumentException("Invalid data provided for addVehicule.");
    }

    $database = dbConnect();
    $query = "INSERT INTO vehicule (nom) VALUES (:nom)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->execute();
}
function updateVehicule($data){
    $database = dbConnect();
    
    $query = "UPDATE vehicule SET nom = :nom WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->execute();
}
function removeVehicule($id) { deleteRecord('vehicule', 'id', $id); }
// Vehicule function
function addProd($data) {
    $database = dbConnect(); $query = ("INSERT INTO produits (nom, prix, id, img) VALUES (:nom, :prix, :categorie_id, :img)");
    $stmt = $database->prepare($query); $stmt->bindValue(":nom", $data['nom']); $stmt->bindValue(":prix", $data['prix']);
    $stmt->bindValue(":categorie_id", $data['categorie_id']); $stmt->bindValue(":img", $data['img']); $stmt->execute();
}
// Fonctions pour lire des enregistrements dans différentes tables
function getCats() { 
    $database = dbConnect();
    $stmt = $database->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getProducts() { 
    $database = dbConnect();
    $stmt = $database->query("SELECT * FROM produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getT() {
    $database = dbConnect();
    $stmt = $database->query("SELECT * FROM transactions");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// D'autres fonctions spécifiques pour obtenir des enregistrements par ID pour différentes tables
function getProduitById($id) { return getById('produits', 'id', $id); }
function getCatById($id) { return getById('categories', 'id', $id); }
function getTById($id) { return getById('transactions', 'id', $id); }
// Fonctions pour supprimer des enregistrements de différentes tables
function removeCat($id) { deleteRecord('categories', 'id', $id); }
function removeProd($id) { deleteRecord('produits', 'id', $id); }
// Fonctions pour mettre à jour des enregistrements dans différentes tables
function updateCat($data) {
    $database = dbConnect(); $query = ("UPDATE categories SET nom = :nom WHERE id = :id");
    $stmt = $database->prepare($query); $stmt->bindValue(":nom", $data['nom']);
    $stmt->bindValue(":id", $data['id'], PDO::PARAM_INT); $stmt->execute();
}
function updateProd($data) {
    $database = dbConnect(); $query = ("UPDATE produits SET nom = :nom, prix=:prix, categorie_id=:categorie_id, img=:img WHERE id = :id");
    $stmt = $database->prepare($query); $stmt->bindValue(":nom", $data['nom']); $stmt->bindValue(":prix", $data['prix']);
    $stmt->bindValue(":categorie_id", $data['categorie_id']); $stmt->bindValue(":img", $data['img']);
    $stmt->bindValue(":id", $data['id'], PDO::PARAM_INT); $stmt->execute();
}
function updateT($data) {
    $database = dbConnect(); $query = ("UPDATE transactions SET statuts = :statuts WHERE id = :id");
    $stmt = $database->prepare($query); $stmt->bindValue(":statuts", $data['statuts']);
    $stmt->bindValue(":id", $data['id'], PDO::PARAM_INT); $stmt->execute();
}
function getProdByCatId(){
    $database = dbConnect();
    $query = $database->prepare('SELECT * FROM produits WHERE categorie_id = :category_id');
    $query->bindParam(':category_id', $_POST['category_id'], PDO::PARAM_INT);
    $query->execute(); return $query->fetchAll(PDO::FETCH_ASSOC);
}
// Last Transaction Id
function lastId() {
    $database = dbConnect();
    $querylastId =  ("SELECT MAX(id) AS last_id FROM transactions");
    $stmt= $database->prepare($querylastId); $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC); return $row['last_id'];
}
function getTotalTransactions($startDate, $endDate) {
    $database = dbConnect();
    $query = "SELECT SUM(total) AS total FROM transactions WHERE statuts = 'payé' AND date BETWEEN :startDate AND :endDate";
    $stmt = $database->prepare($query);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ? $result['total'] : 0;
}
function getTransactionTotals() {
    $today = date('Y-m-d'); $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $startOfMonth = date('Y-m-01'); $startOfYear = date('Y-01-01');
    $totals = [
        'today' => getTotalTransactions($today, $today), 'week' => getTotalTransactions($startOfWeek, $today),
        'month' => getTotalTransactions($startOfMonth, $today), 'year' => getTotalTransactions($startOfYear, $today),
        'total' => getTotalTransactions('1970-01-01', $today), // Start date from the epoch
    ];
    return $totals;
}