<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getVehiculeById($id) { return getById('vehicule', 'id', $id); }

$mod = getVehiculeById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="vehicule_id">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom *</label>
        <input type="text" class="form-control" value="<?=$mod['nom']?>" id="vehicule_nom">
    </div>
</form>
<?php } ?>