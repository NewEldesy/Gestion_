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
        <label for="produit" class="form-label">Produits</label>
        <select id="stock_produit" name="produit" class="form-select">
            <option value="">Sélectionnez un Produit</option>
            <?php 
                $produits = getProduits();
                foreach($produits as $produit) {
            ?>
            <option value="<?=$produit['id'];?>" <?=$produit['id'] == $mod['id_produit'] ? 'selected' : '';?>><?=$produit['designation'];?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="quantite" class="form-label">Quantité</label>
        <input type="number" class="form-control" value="<?=$mod['quantite']?>" id="stock_quantite" name="quantite" required>
    </div>
</form>
<?php } ?>