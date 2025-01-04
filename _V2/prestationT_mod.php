<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getPTById($id) { return getById('Tractage', 'id', $id); }

$mod = getPTById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="pt_id">
        <div class="mb-3">
            <label for="immatriculation" class="form-label">N° Immatriculation</label>
            <input type="text" class="form-control" id="pt_num_immatriculation" value="<?=$mod['num_immatriculation']?>" required>
        </div>
        <div class="mb-3">
            <label for="vehicule" class="form-label">Marque Véhicule</label>
            <select id="pt_vehicule" class="form-select">
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
            <input type="text" class="form-control" id="pt_proprietaire_contact" value="<?=$mod['proprietaire_contact']?>" required>
        </div>
        <div class="mb-3">
            <label for="lieu_kilometrage" class="form-label">Lieu Kilometrage</label>
            <input type="text" class="form-control" id="pt_lieu_kilometrage" value="<?=$mod['lieu_kilometrage']?>" required>
        </div>
        <div class="mb-3">
            <label for="date_entree" class="form-label">Date Tractage</label>
            <input type="date" class="form-control" id="pt_date_entree" value="<?=$mod['date_entree']?>" required>
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant Prestation</label>
            <input type="number" class="form-control" id="pt_montant" value="<?=$mod['montant']?>" required>
        </div>
        <div class="mb-3">
            <label for="prestataire" class="form-label">Prestataire</label>
            <select id="pt_prestataire" class="form-select">
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
            <textarea class="form-control" id="pt_observation" rows="3" required><?=$mod['observation']?></textarea>
        </div>
</form>
<?php } ?>