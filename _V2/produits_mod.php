<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getProduitsById($id) { return getById('Produits', 'id', $id); }

$mod = getProduitsById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="produit_id">
    <div class="mb-3">
        <label for="designation" class="form-label">Designation</label>
        <input type="text" class="form-control" value="<?=$mod['designation']?>" id="produit_designation">
    </div>
    <div class="mb-3">
        <label for="vehicule" class="form-label">Marque Véhicule</label>
        <select name="vehicule" id="produit_vehicule" class="form-select">
            <option value="">Sélectionnez un Vehicule</option>
            <?php 
                $vehicules = getVehicule();
                foreach($vehicules as $vehicule) {
            ?>
            <option value="<?=$vehicule['id'];?>" <?= $vehicule['id'] == $mod['vehicule'] ? 'selected' : ''; ?>><?=$vehicule['nom'];?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="prixunitaire" class="form-label">Prix Unitaire</label>
        <input type="text" class="form-control" value="<?=$mod['pu']?>" id="produit_prixunitaire">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="produit_description" rows="3"><?=$mod['description']?></textarea>
    </div>
</form>
<?php } ?>