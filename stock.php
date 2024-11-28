<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM Stock");
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Stocks</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
                    Gérer Stock
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-5">Stock</h5>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produits</th>
                        <th>Quantité</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stocks)) {
                        foreach ($stocks as $stock) { ?>
                            <tr>
                                <td><?=htmlspecialchars($stock['id']);?></td>
                                <td><?=htmlspecialchars($stock['id_produit']);?></td>
                                <td><?=htmlspecialchars($stock['quantite']);?></td>
                                <td>
                                    <a href="stock_delete.php?id=<?= htmlspecialchars($stock['id']); ?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$stock['id'];?>" data-produit="<?=htmlspecialchars($stock['id_produit']);?>" data-quantite="<?=htmlspecialchars($stock['quantite']);?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de Produits en Stocks !!!
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Ajout-->
<div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Stock Produits</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="stock_add.php" method="POST">
                    <div class="mb-3">
                        <label for="produit" class="form-label">Produits</label>
                        <input type="text" class="form-control" id="produit" name="produit" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="text" class="form-control" id="quantite" name="quantite" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ajout-->

<!-- Modal Modification-->
<div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateModal">Modifier Stock Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="stock_update.php" method="POST">
                    <input type="hidden" name="id" id="stock_id">
                    <div class="mb-3">
                        <label for="produit" class="form-label">Produits</label>
                        <input type="text" class="form-control" id="stock_produit" name="produit" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="stock_quantite" name="quantite" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Modification-->

<!-- JavaScript -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dataTables/js/dataTables.js"></script>
<script>
    // Remplir les champs du modal "Modifier" avec les données
    var exampleModalMaj = document.getElementById('exampleModalMaj');
    exampleModalMaj.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var produit = button.getAttribute('data-produit');
        var quantite = button.getAttribute('data-quantite');

        // Remplir les champs cachés et visibles
        document.getElementById('stock_id').value = id;
        document.getElementById('stock_produit').value = produit;
        document.getElementById('stock_quantite').value = quantite;
    });
</script>