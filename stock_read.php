<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT s.id, s.quantite, s.id_produit, p.designation AS nom_produit FROM stock s LEFT JOIN produits p ON s.id_produit = p.id");
$stmt->execute();
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-12 order-md-1">
   <h5 class="mb-5">Stock Produits</h5>
   <div class="table-responsive">
      <table id="stock" class="table table-striped table-sm">
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
                <td><?=htmlspecialchars($stock['nom_produit']);?></td>
                <td><?=htmlspecialchars($stock['quantite']);?></td>
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
                           Pas de stocks enregistrés !!!
                        </div>
                     </td>
                  </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
</div>

<script>new DataTable('#stock'); </script>