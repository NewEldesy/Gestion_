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
// Prestataire function
function addPrestataire($data) {
    if (!is_array($data) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['date_naissance']) || !isset($data['description']) || !isset($data['poste'])) {
        throw new InvalidArgumentException("Invalid data provided for addPrestaire.");
    }

    $database = dbConnect();
    $query = "INSERT INTO prestataire (nom, prenom, date_naissance, telephone, telephone2, poste) VALUES (:nom, :prenom, :date_naissance, :telephone, :telephone2, :poste)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR); $stmt->bindValue(':prenom', $data['nom'], PDO::PARAM_STR);
    $stmt->bindValue(':date_naissance', $data['date_naissance'], PDO::PARAM_STR); $stmt->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
    $stmt->bindValue(':telephone2', $data['telephone2'], PDO::PARAM_STR); $stmt->bindValue(':poste', $data['poste'], PDO::PARAM_STR);
    $stmt->execute();
}
function updatePrestataire($data){
    $database = dbConnect();
    
    $query = "UPDATE prestataire SET nom=:nom, prenom=:prenom, date_naissance=:date_naissance, telephone=:telephone, telephone2=:telephone2, poste=:poste WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR); $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
    $stmt->bindValue(':date_naissance', $data['date_naissance'], PDO::PARAM_STR); $stmt->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
    $stmt->bindValue(':telephone2', $data['telephone2'], PDO::PARAM_STR); $stmt->bindValue(':poste', $data['poste'], PDO::PARAM_STR);
    $stmt->execute();
}
function removePrestataire($id) { deleteRecord('prestataire', 'id', $id); }
// Prestataire function
// Produits function
function addProduit($data) {
    if (!is_array($data) || !isset($data['designation']) || !isset($data['vehicule']) || !isset($data['pu'])) {
        throw new InvalidArgumentException("Invalid data provided for addProduit.");
    }

    $database = dbConnect();
    $query = "INSERT INTO Produits (designation, vehicule, pu, description) VALUES (:designation, :vehicule, :pu, :description)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':pu', $data['pu'], PDO::PARAM_STR); $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();
}
function updateProduits($data){
    $database = dbConnect();
    
    $query = "UPDATE Produits SET designation=:designation, vehicule=:vehicule, pu=:pu, description=:description WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':pu', $data['pu'], PDO::PARAM_STR); $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();
}
function removeProduits($id) { deleteRecord('Produits', 'id', $id); }
// Produits function
// Fonctions pour lire des enregistrements dans différentes tables
function getProducts() { 
    $database = dbConnect();
    $stmt = $database->query("SELECT * FROM produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// D'autres fonctions spécifiques pour obtenir des enregistrements par ID pour différentes tables
function getProduitById($id) { return getById('produits', 'id', $id); }
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