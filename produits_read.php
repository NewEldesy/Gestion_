<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT p.id, p.designation, p.pu, p.description, p.vehicule, v.nom AS vehicule_nom FROM produits p LEFT JOIN vehicule v ON p.vehicule = v.id");
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-12 order-md-1">
   <h5 class="mb-5">Liste des Prestataires</h5>
   <div class="table-responsive">
      <table id="Produit" class="table table-striped table-sm">
         <thead>
            <tr>
                <th>#</th>
                <th>Désignation</th>
                <th>Marque Véhicule</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Options</th>
            </tr>
         </thead>
         <tbody>
            <?php if (!empty($produits)) {
                  foreach ($produits as $produit) { ?>
            <tr>
                <td><?=htmlspecialchars($produit['id']);?></td>
                <td><?=htmlspecialchars($produit['designation']);?></td>
                <td><?=htmlspecialchars($produit['vehicule_nom']);?></td>
                <td><?=htmlspecialchars($produit['pu']);?> FCFA</td>
                <td><?=htmlspecialchars($produit['description']);?></td>
               <td>
                  <a href="#" class="btn_del_produit btn btn-sm btn-danger" data-id="<?=$produit['id'];?>">Supprimer</a>
                  <a href="#" id="btn_up_produit" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?= $produit['id']; ?>" class="btn btn-sm btn-warning"></i>Modifier</a>
               </td>
            </tr>
            <?php } 
               } else { ?>
                  <tr>
                     <td colspan="6" class="text-center">
                        <div class="alert alert-warning" role="alert">
                           Pas de produits enregistrés !!!
                        </div>
                     </td>
                  </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
</div>

<script> new DataTable('#Produit'); </script>