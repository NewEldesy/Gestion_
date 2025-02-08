<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
$mod = getUsersById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="u_id">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom(s)</label>
        <input type="text" class="form-control" value="<?=$mod['nom']?>" id="u_nom">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prenom</label>
        <input type="text" class="form-control" value="<?=$mod['prenom']?>" id="u_prenom">
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" value="<?=$mod['username']?>" id="u_username">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="u_password">
    </div>
</form>
<?php } ?>