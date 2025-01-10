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
function deleteRecord($table, $idColumn, $id) {
    $database = dbConnect();
    $stmt = $database->prepare("DELETE FROM {$table} WHERE {$idColumn} = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); $stmt->execute();
}
function getById($table, $idColumn, $id) {
    $database = dbConnect();
    $stmt = $database->prepare("SELECT * FROM {$table} WHERE {$idColumn} = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); return $stmt->fetch(PDO::FETCH_ASSOC);
}
function try_login($username) {
    $database = dbConnect();
    $stmt = $database->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute(); $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}
function getTotalTransactions($startDate, $endDate) { // Start Gestion Vente
    $database = dbConnect();
    $query = "SELECT SUM(total) AS total FROM Vente WHERE date_vente BETWEEN :startDate AND :endDate";
    $stmt = $database->prepare($query); $stmt->bindParam(':startDate', $startDate); $stmt->bindParam(':endDate', $endDate);
    $stmt->execute(); $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ? $result['total'] : 0;}
function getTransactionTotals() {
    $today = date('Y-m-d'); $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $startOfMonth = date('Y-m-01'); $startOfYear = date('Y-01-01');
    $totals = [ 'today' => getTotalTransactions($today, $today), 'week' => getTotalTransactions($startOfWeek, $today),
        'month' => getTotalTransactions($startOfMonth, $today), 'year' => getTotalTransactions($startOfYear, $today),
        'total' => getTotalTransactions('1970-01-01', $today),];
    return $totals;}
    function getIdVente() {
        $database = dbConnect();
        $query = "SELECT MAX(id) AS lastId FROM Vente";
        $stmt = $database->prepare($query); $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC); return $data['lastId'];}
// Add Vente
function addVente($data) {
    $database = dbConnect();
    
    $VenteId = $data['venteId'];
    $date = date('Y-m-d'); $total = $data['total'];
    $remise = isset($data['remise']) && is_numeric($data['remise']) ? $data['remise'] : 0; // Remise par défaut à 0 si non envoyée
    $statuts = $data['statuts']; $items = json_decode($data['items'], true); // Décoder le JSON des éléments
    
    $database->beginTransaction(); // Début de la transaction
    try {
        // Calculer le total après remise
        $totalAvecRemise = $total - ($total * $remise / 100);

        // Insérer les données dans la table `Vente`
        $queryFacture = "INSERT INTO Vente (date_vente, total, remise, statuts) VALUES (:date_vente, :total, :remise, :statuts)";
        $stmtFacture = $database->prepare($queryFacture);
        $stmtFacture->bindValue(':date_vente', $date); $stmtFacture->bindValue(':total', $totalAvecRemise);
        $stmtFacture->bindValue(':remise', $remise); $stmtFacture->bindValue(':statuts', $statuts);
        $stmtFacture->execute();
        // Insérer les éléments de la facture dans la table `transaction_details`
        $queryElementFacture = "INSERT INTO elementVente (vente, produit, pu, quantite, soustotal) VALUES (:vente, :produit, :pu, :quantite, :soustotal)";
        $stmt = $database->prepare($queryElementFacture);
        // Mettre à jour les quantités des produits dans le stock
        $queryUpdateStock = "UPDATE Stock SET quantite = :quantite WHERE id_produit = :id_produit";
        $stmtUpdateStock = $database->prepare($queryUpdateStock);
        // Boucle pour traiter chaque élément de la facture
        foreach ($items as $element) {
            $produit = $element['produitId'];
            $pu = $element['produitPrix'];
            $quantite = $element['quantite'];
            $soustotal = $element['sousTotal'];
            // Ajouter à `transaction_details`
            $stmt->bindValue(':vente', $VenteId);
            $stmt->bindValue(':produit', $produit);
            $stmt->bindValue(':pu', $pu);
            $stmt->bindValue(':quantite', $quantite);
            $stmt->bindValue(':soustotal', $soustotal);
            $stmt->execute();
            // Réduire la quantité dans `Stock`
            $qty = getQtyById($produit);
            $quantiteF = $qty - $quantite;
            $stmtUpdateStock->bindValue(':quantite', $quantiteF, PDO::PARAM_INT);
            $stmtUpdateStock->bindValue(':id_produit', $produit, PDO::PARAM_INT);
            $stmtUpdateStock->execute();
        }
        $database->commit(); // Valider la transaction
    } catch (Exception $e) {
        $database->rollBack(); // Annuler la transaction en cas d'erreur
        throw $e; // Rejeter l'erreur pour un traitement ultérieur
    }
}
// End Gestion Vente

// Start Gestion Produits Et Stock
// Produits Function
function addProduit($data) {
    if (!is_array($data) || !isset($data['designation']) || !isset($data['pu'])) {throw new InvalidArgumentException("Invalid data provided for addProduit.");}
    $database = dbConnect();
    $query = "INSERT INTO Produits (designation, pu, description) VALUES (:designation, :pu, :description)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR); $stmt->bindValue(':pu', $data['pu'], PDO::PARAM_STR); 
    $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR); $stmt->execute();
    $productId = $database->lastInsertId(); // Récupérer l'ID du produit inséré
    $stockQuery = "INSERT INTO Stock (id_produit, quantite) VALUES (:id_produit, :quantite)"; // Insérer une entrée dans la table Stock avec la quantité initialisée à 0
    $stockStmt = $database->prepare($stockQuery);
    $stockStmt->bindValue(':id_produit', $productId, PDO::PARAM_INT);
    $stockStmt->bindValue(':quantite', 0, PDO::PARAM_INT);
    $stockStmt->execute();}
function updateProduits($data){
    $database = dbConnect();
    $query = "UPDATE Produits SET designation=:designation, pu=:pu, description=:description WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT); $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR);
    $stmt->bindValue(':pu', $data['pu'], PDO::PARAM_STR); $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();}
function removeProduits($id) { deleteRecord('Produits', 'id', $id); }
function getProduits() { 
    $database = dbConnect();
    $stmt = $database->query("SELECT id, designation FROM Produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);}
function getProducts() {
    $database = dbConnect();
    $stmt = $database->prepare("SELECT p.id, p.designation, p.pu, s.quantite FROM Produits p
        LEFT JOIN Stock s ON p.id = s.id_produit WHERE s.quantite IS NOT NULL");
    $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_ASSOC);}
// Stocks Function
function addStock($data) {
    if (!is_array($data) || !isset($data['id_produit']) || !isset($data['quantite'])) { throw new InvalidArgumentException("Invalid data provided for addStock.");}
    $database = dbConnect();
    $queryCheck = "SELECT quantite FROM Stock WHERE id_produit = :id_produit";
    $stmtCheck = $database->prepare($queryCheck);
    $stmtCheck->bindValue(':id_produit', $data['id_produit'], PDO::PARAM_INT);
    $stmtCheck->execute();
    $productExists = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    if ($productExists) {return null;}
    else {
        $queryInsert = "INSERT INTO Stock (id_produit, quantite) VALUES (:id_produit, :quantite)";
        $stmtInsert = $database->prepare($queryInsert);
        $stmtInsert->bindValue(':id_produit', $data['id_produit'], PDO::PARAM_INT);
        $stmtInsert->bindValue(':quantite', $data['quantite'], PDO::PARAM_INT);
        $stmtInsert->execute();}}
function updateStock($data){
    $database = dbConnect();
    $query = "UPDATE Stock SET id_produit=:id_produit, quantite=:quantite WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':id_produit', $data['id_produit'], PDO::PARAM_STR); $stmt->bindValue(':quantite', $data['quantite'], PDO::PARAM_STR);
    $stmt->execute();}
function removeStock($id) { deleteRecord('Stock', 'id', $id); }
function getQtyById($id) {
    $database = dbConnect();
    $stmt = $database->prepare("SELECT quantite FROM Stock WHERE id_produit = :id_produit");
    $stmt->bindParam(':id_produit', $id, PDO::PARAM_INT); $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); return $result['quantite'];}
// End Gestion Produits Et Stock
// Start Gestion Prestation
function addPrestation($data) {
    if (!is_array($data) || !isset($data['designation']) || !isset($data['prix'])) {throw new InvalidArgumentException("Invalid data provided for addPrestation.");}
    $database = dbConnect();
    $query = "INSERT INTO prestations (designation, prix, description) VALUES (:designation, :prix, :description)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR);
    $stmt->bindValue(':prix', $data['prix'], PDO::PARAM_STR); 
    $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();}
function updatePrestation($data){
    $database = dbConnect();
    $query = "UPDATE prestations SET designation= :designation, prix= :prix, description=:description WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR); $stmt->bindValue(':prix', $data['prix'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR); $stmt->execute();}
function removePrestation($id) { deleteRecord('prestations', 'id', $id); }
function getPrestations(){
    $database = dbConnect();
    $stmt = $database->prepare("SELECT * FROM prestations");
    $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getIdPrestation() {
    $database = dbConnect();
    $query = "SELECT MAX(id) AS lastId FROM prestation";
    $stmt = $database->prepare($query); $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC); return $data['lastId'];}
function add_Prestation($data) {
    $database = dbConnect();

    $PrestationId = $data['venteId']; $prestataire = $data['prestataire'];
    $date = date('Y-m-d'); $total = $data['total'];
    $remise = isset($data['remise']) && is_numeric($data['remise']) ? $data['remise'] : 0; // Remise par défaut à 0 si non envoyée
    $items = json_decode($data['items'], true); // Décoder le JSON des éléments
    $database->beginTransaction(); // Début de la transaction
    try {
        // Insérer les données dans la table `Vente`
        $queryPrestation = "INSERT INTO prestation (id_prestataire, total, remise, date) VALUES (:id_prestataire, :total, :remise, :date)";
        $stmtPrestation = $database->prepare($queryPrestation);
        $stmtPrestation->bindParam(':id_prestataire', $prestataire); $stmtPrestation->bindParam(':total', $total);
        $stmtPrestation->bindParam(':remise', $remise); $stmtPrestation->bindParam(':date', $date);
        $stmtPrestation->execute();
        // Insérer les éléments de la facture dans la table `transaction_details`
        $queryElementPrestation = "INSERT INTO element_prestation (id_prestation, element_prestations, prix) VALUES (:id_prestation, :element_prestations, :prix)";
        $stmt = $database->prepare($queryElementPrestation);
        // Boucle pour traiter chaque élément de la facture
        var_dump($items);
        foreach ($items as $element) {
            $produit = $element['produitId'];
            $pu = $element['produitPrix'];
            // Ajouter à `transaction_details`
            $stmt->bindValue(':id_prestation', $PrestationId);
            $stmt->bindValue(':element_prestations', $produit);
            $stmt->bindValue(':prix', $pu);
            $stmt->execute();
        }
        $database->commit(); // Valider la transaction
    } catch (Exception $e) {
        $database->rollBack(); // Annuler la transaction en cas d'erreur
        throw $e; // Rejeter l'erreur pour un traitement ultérieur
    }
}
function getTotalFromTables($startDate, $endDate) {
    $database = dbConnect();
    $query = "SELECT SUM(total) AS total FROM prestation WHERE date BETWEEN :startDate AND :endDate";
    $stmt = $database->prepare($query); $stmt->bindParam(':startDate', $startDate); $stmt->bindParam(':endDate', $endDate);
    $stmt->execute(); $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ? $result['total'] : 0;}
function getPrestationTotals() {
    $today = date('Y-m-d'); $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $startOfMonth = date('Y-m-01'); $startOfYear = date('Y-01-01');
    $totals = [
        'today' => getTotalFromTables($today, $today),
        'week' => getTotalFromTables($startOfWeek, $today),
        'month' => getTotalFromTables($startOfMonth, $today),
        'year' => getTotalFromTables($startOfYear, $today),
        'total' => getTotalFromTables('1970-01-01', $today),
    ];
    return $totals;}
function getElementPrestationById($id){
    $database = dbConnect();
    $query = "SELECT * FROM element_prestation WHERE id_prestation= :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getPrestationsById($id){ return getById('prestations', 'id', $id);}
function getPrestationById($id){ return getById('prestation', 'id', $id);}
// End Gestion Prestation
// Start Gestion Prestataire
function addPrestataire($data) {
    if (!is_array($data) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['date_naissance']) || !isset($data['telephone']) || !isset($data['poste'])) {throw new InvalidArgumentException("Invalid data provided for addPrestaire.");}
    $database = dbConnect();
    $query = "INSERT INTO prestataire (nom, prenom, date_naissance, telephone, telephone2, poste) VALUES (:nom, :prenom, :date_naissance, :telephone, :telephone2, :poste)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR); $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
    $stmt->bindValue(':date_naissance', $data['date_naissance'], PDO::PARAM_STR); $stmt->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
    $stmt->bindValue(':telephone2', $data['telephone2'], PDO::PARAM_STR); $stmt->bindValue(':poste', $data['poste'], PDO::PARAM_STR);
    $stmt->execute();}   
function updatePrestataire($data){
    $database = dbConnect();
    $query = "UPDATE prestataire SET nom=:nom, prenom=:prenom, date_naissance=:date_naissance, telephone=:telephone, telephone2=:telephone2, poste=:poste WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR); $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
    $stmt->bindValue(':date_naissance', $data['date_naissance'], PDO::PARAM_STR); $stmt->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
    $stmt->bindValue(':telephone2', $data['telephone2'], PDO::PARAM_STR); $stmt->bindValue(':poste', $data['poste'], PDO::PARAM_STR);
    $stmt->execute();}
function removePrestataire($id) { deleteRecord('prestataire', 'id', $id); }
function getPrestataire() {
    $database = dbConnect();
    $stmt = $database->prepare("SELECT id, nom, prenom FROM prestataire");
    $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_ASSOC);}
// End Gestion Prestataire

// Start Gestion Vehicule
function addVehicule($data) {
    if (!is_array($data) || !isset($data['nom'])) { throw new InvalidArgumentException("Invalid data provided for addVehicule.");}
    $database = dbConnect();
    $query = "INSERT INTO vehicule (nom) VALUES (:nom)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->execute();}
function updateVehicule($data){
    $database = dbConnect();
    $query = "UPDATE vehicule SET nom = :nom WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->execute();}
function removeVehicule($id) { deleteRecord('vehicule', 'id', $id); }
function getVehicule() {
    $database = dbConnect(); $query = "SELECT * FROM Vehicule";
    $stmt = $database->prepare($query); $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);}
// End Gestion Vehicule