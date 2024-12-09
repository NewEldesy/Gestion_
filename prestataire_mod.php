<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getPrestataireById($id) { return getById('prestataire', 'id', $id); }

$mod = getPrestataireById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="pres_id">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom *</label>
        <input type="text" class="form-control" value="<?=$mod['nom']?>" id="pres_nom">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom *</label>
        <input type="text" class="form-control" value="<?=$mod['prenom']?>" id="pres_prenom">
    </div>
    <div class="mb-3">
        <label for="date_naissance" class="form-label">Date de Naissance *</label>
        <input type="date" class="form-control" value="<?=$mod['date_naissance']?>" id="pres_date_naissance">
    </div>
    <div class="mb-3">
        <label for="telephone" class="form-label">Téléphone *</label>
        <input type="text" class="form-control" value="<?=$mod['telephone']?>" id="pres_telephone">
    </div>
    <div class="mb-3">
        <label for="telephone2" class="form-label">Téléphone2</label>
        <input type="text" class="form-control" value="<?=$mod['telephone2']?>" id="pres_telephone2">
    </div>
    <div class="mb-3">
        <label for="poste" class="form-label">Poste *</label>
        <input type="text" class="form-control" value="<?=$mod['poste']?>" id="pres_poste">
    </div>
</form>
<?php } ?>