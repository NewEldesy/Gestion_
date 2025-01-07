<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getPrestationsById($id) { return getById('prestations', 'id', $id); }

$mod = getPrestationsById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="prestation_id">
    <div class="mb-3">
        <label for="designation" class="form-label">Designation</label>
        <input type="text" class="form-control" value="<?=$mod['designation']?>" id="prestation_designation">
    </div>
    <div class="mb-3">
        <label for="prix" class="form-label">Prix</label>
        <input type="text" class="form-control" value="<?=$mod['prix']?>" id="prestation_prix">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="prestation_description" rows="3"><?=$mod['description']?></textarea>
    </div>
</form>
<?php } ?>