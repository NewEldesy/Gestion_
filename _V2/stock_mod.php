<?php
include ("model.php");
$database = dbConnect();

$modif = $_POST['id'];
function getStockById($id) { return getById('Stock', 'id', $id); }

$mod = getStockById($modif);

if (!empty($mod)) {
?>
<form method="POST">
    <input type="hidden" value="<?=$mod['id']?>" id="stock_id">
    <div class="mb-3">
        <input type="hidden" value="<?=$mod['id_produit']?>" id="stock_produit">
        <label for="produit" class="form-label">Produits</label>
        <?php $id_prod = $mod['id_produit']; $produit = getProduitsById($id_prod);?>
        <input type="text" class="form-control" value="<?=$produit['designation']?>" name="produit" required>
    </div>
    <div class="mb-3">
        <label for="quantite" class="form-label">Quantité</label>
        <input type="number" class="form-control" value="<?=$mod['quantite']?>" id="stock_quantite" name="quantite" required>
    </div>
</form>
<?php } ?>