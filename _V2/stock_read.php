<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT s.id, s.quantite, s.id_produit, p.designation AS nom_produit FROM stock s LEFT JOIN produits p ON s.id_produit = p.id");
$stmt->execute();
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Stock Produits</h5>
<table class="table align-middle mb-0 p-5" id="Stock">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">Produits</th>
            <th scope="col" class="text-center">Quantité</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($stocks)) {
            foreach ($stocks as $stock) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($stock['id']);?></th>
            <td class="text-center fw-medium"><?=htmlspecialchars($stock['nom_produit']);?></td>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($stock['quantite']);?></th>
            <td>
                <!-- <a href="#" class="btn_del_stock btn btn-sm btn-danger" data-id="<?//=$stock['id'];?>">Supprimer</a> -->
                <a href="#" id="btn_up_stock" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?= $stock['id']; ?>" class="btn btn-sm btn-warning"></i>Modifier</a>
            </td>
        </tr>
        <?php } 
            } else { ?>
                <tr>
                    <td colspan="4" class="text-center">
                    <div class="alert alert-warning" role="alert">
                        Pas de produits en stock !!!
                    </div>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<script> new DataTable('#Stock'); </script>