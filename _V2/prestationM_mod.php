<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getPMById($id) { return getById('Mecaniques', 'id', $id); }

$mod = getPMById($modif);

if (!empty($mod)) {
?>
<form action="prestationM_update.php" method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="pm_id">
        <div class="mb-3">
            <label for="immatriculation" class="form-label">N° Immatriculation</label>
            <input type="text" class="form-control" id="pm_num_immatriculation" value="<?=$mod['num_immatriculation']?>" required>
        </div>
        <div class="mb-3">
            <label for="vehicule" class="form-label">Marque Véhicule</label>
            <select id="pm_vehicule" class="form-select">
                <option value="">Sélectionnez un Vehicule</option>
                <?php 
                    $vehicules = getVehicule();
                    foreach($vehicules as $vehicule) {
                ?>
                <option value="<?=$vehicule['id'];?>" <?= $vehicule['id']==$mod['vehicule']?'selected':'';?>><?=$vehicule['nom'];?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="proprietaire_contact" class="form-label">Contact Propriétaire</label>
            <input type="text" class="form-control" id="pm_proprietaire_contact" value="<?=$mod['proprietaire_contact']?>" required>
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant Prestatation</label>
            <input type="number" class="form-control" id="pm_montant" value="<?=$mod['montant']?>" required>
        </div>
        <div class="mb-3">
            <label for="date_entree" class="form-label">Date Entrée</label>
            <input type="date" class="form-control" id="pm_date_entree" value="<?=$mod['date_entree']?>" required>
        </div>
        <div class="mb-3">
            <label for="date_sortie" class="form-label">Date Sortie</label>
            <input type="date" class="form-control" id="pm_date_sortie" value="<?=$mod['date_sortie']?>" required>
        </div>
        <div class="mb-3">
            <label for="prestataire" class="form-label">Prestataire</label>
            <select id="pm_prestataire" name="prestataire" class="form-select">
                <option value="">Sélectionnez un Prestataire</option>
                <?php 
                $prestataires = getPrestataire();
                foreach($prestataires as $prestataire) {
                ?>
                <option value="<?=$prestataire['id'];?>" <?= $prestataire['id']==$mod['prestataire']?'selected':'';?>><?=$prestataire['nom'];?> <?=$prestataire['prenom'];?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="observation" class="form-label">Observation</label>
            <textarea class="form-control" id="pm_observation" rows="3" required><?=$mod['observation']?></textarea>
        </div>
</form>
<?php } ?>