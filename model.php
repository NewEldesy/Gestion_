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
// Start Gestion Vente
function getTotalTransactions($startDate, $endDate) {
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
    
    $transactionId = $data['venteId'];
    $date = date('Y-m-d'); $total = $data['total'];
    $remise = isset($data['remise']) && is_numeric($data['remise']) ? $data['remise'] : 0; // Remise par défaut à 0 si non envoyée
    $statuts = $data['statuts']; $items = json_decode($data['items'], true); // Décoder le JSON des éléments
    
    $database->beginTransaction(); // Début de la transaction
    try {
        // Calculer le total après remise
        $totalAvecRemise = $total - ($total * $remise / 100);

        // Insérer les données dans la table `Vente`
        $queryFacture = "INSERT INTO Vente (date_vente, total, remise, statuts) 
                         VALUES (:date_vente, :total, :remise, :statuts)";
        $stmtFacture = $database->prepare($queryFacture);
        $stmtFacture->bindParam(':date_vente', $date);
        $stmtFacture->bindParam(':total', $totalAvecRemise);
        $stmtFacture->bindParam(':remise', $remise);
        $stmtFacture->bindParam(':statuts', $statuts);
        $stmtFacture->execute();

        // Insérer les éléments de la facture dans la table `transaction_details`
        $queryElementFacture = "INSERT INTO elementVente (vente, produit, pu, quantite, soustotal) 
                                VALUES (:vente, :produit, :pu, :quantite, :soustotal)";
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
            $stmt->bindParam(':vente', $transactionId);
            $stmt->bindParam(':produit', $produit);
            $stmt->bindParam(':pu', $pu);
            $stmt->bindParam(':quantite', $quantite);
            $stmt->bindParam(':soustotal', $soustotal);
            $stmt->execute();

            // Réduire la quantité dans `Stock`
            $qty = getQtyById($produit);
            $quantiteF = $qty - $quantite;
            $stmtUpdateStock->bindParam(':quantite', $quantiteF, PDO::PARAM_INT);
            $stmtUpdateStock->bindParam(':id_produit', $produit, PDO::PARAM_INT);
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
    if (!is_array($data) || !isset($data['designation']) || !isset($data['vehicule']) || !isset($data['pu'])) {throw new InvalidArgumentException("Invalid data provided for addProduit.");}
    $database = dbConnect();
    $query = "INSERT INTO Produits (designation, vehicule, pu, description) VALUES (:designation, :vehicule, :pu, :description)";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR); 
    $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':pu', $data['pu'], PDO::PARAM_STR); 
    $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();
    $productId = $database->lastInsertId(); // Récupérer l'ID du produit inséré
    $stockQuery = "INSERT INTO Stock (id_produit, quantite) VALUES (:id_produit, :quantite)"; // Insérer une entrée dans la table Stock avec la quantité initialisée à 0
    $stockStmt = $database->prepare($stockQuery);
    $stockStmt->bindValue(':id_produit', $productId, PDO::PARAM_INT);
    $stockStmt->bindValue(':quantite', 0, PDO::PARAM_INT);
    $stockStmt->execute();}
function updateProduits($data){
    $database = dbConnect();
    $query = "UPDATE Produits SET designation=:designation, vehicule=:vehicule, pu=:pu, description=:description WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':designation', $data['designation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':pu', $data['pu'], PDO::PARAM_STR); $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    $stmt->execute();}
function removeProduits($id) { deleteRecord('Produits', 'id', $id); }
function getProduits() { 
    $database = dbConnect();
    $stmt = $database->query("SELECT id, designation FROM Produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);}
function getProducts() {
    $database = dbConnect();
    $stmt = $database->query("
        SELECT p.id, p.designation,p.pu , s.quantite FROM Produits p
        LEFT JOIN Stock s ON p.id = s.id_produit WHERE s.quantite IS NOT NULL");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);}
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
// Prestation Mécanique Function
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
    $stmt->execute();}
    function removePM($id) { deleteRecord('Mecaniques', 'id', $id); }
    function addPM($data) {
        if (!is_array($data) || !isset($data['num_immatriculation']) || !isset($data['vehicule']) || !isset($data['montant']) || !isset($data['proprietaire_contact']) || !isset($data['date_entree'])
            || !isset($data['date_sortie']) || !isset($data['prestataire']) || !isset($data['observation'])) {throw new InvalidArgumentException("Invalid data provided for addPrestionM.");}
        $database = dbConnect();
        $query = "INSERT INTO Mecaniques (num_immatriculation, vehicule, montant, proprietaire_contact, date_entree, date_sortie, prestataire, observation) 
            VALUES (:num_immatriculation, :vehicule, :montant, :proprietaire_contact, :date_entree, :date_sortie, :prestataire, :observation)";
        $stmt = $database->prepare($query);
        $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
        $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':proprietaire_contact', $data['proprietaire_contact'], PDO::PARAM_STR);
        $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':date_sortie', $data['date_sortie'], PDO::PARAM_STR);
        $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
        $stmt->execute();}
// Prestation Tractage Function
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
    $stmt->execute();}
    function removePT($id) { deleteRecord('Tractage', 'id', $id); }
    function addPT($data) {
        if (!is_array($data) || !isset($data['num_immatriculation']) || !isset($data['vehicule']) || !isset($data['montant']) || !isset($data['proprietaire_contact']) || !isset($data['date_entree'])
            || !isset($data['lieu_kilometrage']) || !isset($data['prestataire']) || !isset($data['observation'])) {throw new InvalidArgumentException("Invalid data provided for addPrestionT.");}
        $database = dbConnect();
        $query = "INSERT INTO Tractage (num_immatriculation, vehicule, montant, proprietaire_contact, date_entree, lieu_kilometrage, prestataire, observation) 
            VALUES (:num_immatriculation, :vehicule, :montant, :proprietaire_contact, :date_entree, :lieu_kilometrage, :prestataire, :observation)";
        $stmt = $database->prepare($query);
        $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
        $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':proprietaire_contact', $data['proprietaire_contact'], PDO::PARAM_STR);
        $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':lieu_kilometrage', $data['lieu_kilometrage'], PDO::PARAM_STR);
        $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
        $stmt->execute();}
// Prestation Autre Function
function updatePA($data) {
    $database = dbConnect();
    $query = "UPDATE AutreP SET num_immatriculation=:num_immatriculation, vehicule=:vehicule, contact_proprietaire=:contact_proprietaire, type_prestation=:type_prestation,
        montant=:montant, date_entree=:date_entree, prestataire=:prestataire, observation=:observation WHERE id = :id";
    $stmt = $database->prepare($query);
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
    $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':contact_proprietaire', $data['contact_proprietaire'], PDO::PARAM_STR);
    $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':type_prestation', $data['type_prestation'], PDO::PARAM_STR);
    $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
    $stmt->execute();}
    function removePA($id) { deleteRecord('AutreP', 'id', $id); }
    function addPA($data) {
        if (!is_array($data) || !isset($data['num_immatriculation']) || !isset($data['vehicule']) || !isset($data['montant']) || !isset($data['contact_proprietaire']) || !isset($data['date_entree'])
            || !isset($data['type_prestation']) || !isset($data['prestataire']) || !isset($data['observation'])) {throw new InvalidArgumentException("Invalid data provided for addPrestionT.");}
        $database = dbConnect();
        $query = "INSERT INTO AutreP (num_immatriculation, vehicule, contact_proprietaire, type_prestation, montant, date_entree, prestataire, observation) 
            VALUES (:num_immatriculation, :vehicule, :contact_proprietaire, :type_prestation, :montant, :date_entree, :prestataire, :observation)";
        $stmt = $database->prepare($query);
        $stmt->bindValue(':num_immatriculation', $data['num_immatriculation'], PDO::PARAM_STR); $stmt->bindValue(':vehicule', $data['vehicule'], PDO::PARAM_STR);
        $stmt->bindValue(':montant', $data['montant'], PDO::PARAM_STR); $stmt->bindValue(':contact_proprietaire', $data['contact_proprietaire'], PDO::PARAM_STR);
        $stmt->bindValue(':date_entree', $data['date_entree'], PDO::PARAM_STR); $stmt->bindValue(':type_prestation', $data['type_prestation'], PDO::PARAM_STR);
        $stmt->bindValue(':prestataire', $data['prestataire'], PDO::PARAM_STR); $stmt->bindValue(':observation', $data['observation'], PDO::PARAM_STR);
        $stmt->execute();}
    function getTotalFromTables($startDate, $endDate) {
        $database = dbConnect();
        $queries = [ "SELECT SUM(montant) AS total FROM Mecaniques WHERE date_entree BETWEEN :startDate AND :endDate",
            "SELECT SUM(montant) AS total FROM Tractage WHERE date_entree BETWEEN :startDate AND :endDate",
            "SELECT SUM(montant) AS total FROM AutreP WHERE date_entree BETWEEN :startDate AND :endDate"];
        $total = 0;
        foreach ($queries as $query) {
            $stmt = $database->prepare($query); $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate); $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC); $total += $result['total'] ?? 0;}
        return $total;}
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
    function getPrestataire(){
        $database = dbConnect(); $query = "SELECT id, nom, prenom FROM Prestataire";
        $stmt = $database->prepare($query); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_ASSOC);}
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