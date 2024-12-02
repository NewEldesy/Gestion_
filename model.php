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
    if (!is_array($data) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['date_naissance']) || !isset($data['telephone']) || !isset($data['poste'])) {
        throw new InvalidArgumentException("Invalid data provided for addPrestaire.");
    }

    $database = dbConnect();
    $query = "INSERT INTO prestataire (nom, prenom, date_naissance, telephone, telephone2, poste) VALUES (:nom, :prenom, :date_naissance, :telephone, :telephone2, :poste)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR); $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
    $stmt->bindValue(':date_naissance', $data['date_naissance'], PDO::PARAM_STR); $stmt->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
    $stmt->bindValue(':telephone2', $data['telephone2'], PDO::PARAM_STR); $stmt->bindValue(':poste', $data['poste'], PDO::PARAM_STR);
    $stmt->execute();
}
function addPM($data) {
    if (!is_array($data) || !isset($data['num_immatriculation']) || !isset($data['vehicule']) || !isset($data['montant']) || !isset($data['proprietaire_contact']) || !isset($data['date_entree'])
        || !isset($data['date_sortie']) || !isset($data['prestataire']) || !isset($data['observation'])) {
        throw new InvalidArgumentException("Invalid data provided for addPrestionM.");
    }

    $database = dbConnect();
    $query = "INSERT INTO Mecaniques (num_immatriculation, vehicule, montant, proprietaire_contact, date_entree, date_sortie, prestataire, observation) 
        VALUES (:num_immatriculation, :vehicule, :montant, :proprietaire_contact, :date_entree, :date_sortie, :prestataire, :observation)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':proprietaire_contact', $data['proprietaire_contact'], PDO::PARAM_STR);
    $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':date_sortie', $data['date_sortie'], PDO::PARAM_STR);
    $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
    $stmt->execute();
}
function addPT($data) {
    if (!is_array($data) || !isset($data['num_immatriculation']) || !isset($data['vehicule']) || !isset($data['montant']) || !isset($data['proprietaire_contact']) || !isset($data['date_entree'])
        || !isset($data['lieu_kilometrage']) || !isset($data['prestataire']) || !isset($data['observation'])) {
        throw new InvalidArgumentException("Invalid data provided for addPrestionT.");
    }

    $database = dbConnect();
    $query = "INSERT INTO Tractage (num_immatriculation, vehicule, montant, proprietaire_contact, date_entree, lieu_kilometrage, prestataire, observation) 
        VALUES (:num_immatriculation, :vehicule, :montant, :proprietaire_contact, :date_entree, :lieu_kilometrage, :prestataire, :observation)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':proprietaire_contact', $data['proprietaire_contact'], PDO::PARAM_STR);
    $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':lieu_kilometrage', $data['lieu_kilometrage'], PDO::PARAM_STR);
    $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
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
function updatePM($data) {
    $database = dbConnect();
    
    $query = "UPDATE Mecaniques SET num_immatriculation=:num_immatriculation, vehicule=:vehicule, montant=:montant, proprietaire_contact=:proprietaire_contact, 
        date_entree=:date_entree, date_sortie=:date_sortie, prestataire=:prestataire, observation=:observation WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':proprietaire_contact', $data['proprietaire_contact'], PDO::PARAM_STR);
    $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':date_sortie', $data['date_sortie'], PDO::PARAM_STR);
    $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
    $stmt->execute();
}
function updatePT($data) {
    $database = dbConnect();
    
    $query = "UPDATE Tractage SET num_immatriculation=:num_immatriculation, vehicule=:vehicule, montant=:montant, proprietaire_contact=:proprietaire_contact, 
        date_entree=:date_entree, lieu_kilometrage=:lieu_kilometrage, prestataire=:prestataire, observation=:observation WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':proprietaire_contact', $data['proprietaire_contact'], PDO::PARAM_STR);
    $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':lieu_kilometrage', $data['lieu_kilometrage'], PDO::PARAM_STR);
    $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
    $stmt->execute();
}
function removePrestataire($id) { deleteRecord('prestataire', 'id', $id); }
function removePM($id) { deleteRecord('Mecaniques', 'id', $id); }
function removePT($id) { deleteRecord('Tractage', 'id', $id); }
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
// Stocks function
function addStock($data) {
    if (!is_array($data) || !isset($data['id_produit']) || !isset($data['quantite'])) {
        throw new InvalidArgumentException("Invalid data provided for addStock.");
    }

    $database = dbConnect();
    $query = "INSERT INTO Stock (id_produit, quantite) VALUES (:id_produit, :quantite)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id_produit', $data['id_produit'], PDO::PARAM_STR); $stmt->bindValue(':quantite', $data['quantite'], PDO::PARAM_STR);
    $stmt->execute();
}
function updateStock($data){
    $database = dbConnect();
    
    $query = "UPDATE Stock SET id_produit=:id_produit, quantite=:quantite WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':id_produit', $data['id_produit'], PDO::PARAM_STR); $stmt->bindValue(':quantite', $data['quantite'], PDO::PARAM_STR);
    $stmt->execute();
}
function removeStock($id) { deleteRecord('Stock', 'id', $id); }
// Stocks function
// Fonctions pour lire des enregistrements dans différentes tables
function getProduits() { 
    $database = dbConnect();
    $stmt = $database->query("SELECT id, designation FROM Produits");
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
    // $query = "SELECT SUM(total) AS total FROM transactions WHERE statuts = 'payé' AND date BETWEEN :startDate AND :endDate";
    $query = "SELECT SUM(total) AS total FROM Vente WHERE date_vente BETWEEN :startDate AND :endDate";
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
function getIdVente() {
    $database = dbConnect();
    $query = "SELECT MAX(id) AS lastId FROM Vente"; // Remplacez "ventes" par le nom exact de votre table
    $stmt = $database->prepare($query); $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC); return $data['lastId'];
}
function getVehicule() {
    $database = dbConnect();
    $query = "SELECT * FROM Vehicule";
    $stmt = $database->prepare($query); $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getPrestataire(){
    $database = dbConnect();
    $query = "SELECT id, nom, prenom FROM Prestataire";
    $stmt = $database->prepare($query); $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}