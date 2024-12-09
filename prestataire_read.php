<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM prestataire");
$prestataires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-12 order-md-1">
   <h5 class="mb-5">Liste des Prestataires</h5>
   <div class="table-responsive">
      <table id="Prestataire" class="table table-striped table-sm">
         <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date Naissance</th>
                <th>Téléphone</th>
                <th>Téléphone 2</th>
                <th>Poste</th>
                <th>Options</th>
            </tr>
         </thead>
         <tbody>
            <?php if (!empty($prestataires)) {
                  foreach ($prestataires as $prestataire) { ?>
            <tr>
                <td><?=htmlspecialchars($prestataire['id']); ?></td>
                <td><?=htmlspecialchars($prestataire['nom']); ?></td>
                <td><?=htmlspecialchars($prestataire['prenom']); ?></td>
                <td><?=htmlspecialchars($prestataire['date_naissance']); ?></td>
                <td><?=htmlspecialchars($prestataire['telephone']); ?></td>
                <td><?=$prestataire['telephone2'];?></td>
                <td><?=htmlspecialchars($prestataire['poste']); ?></td>
               <td>
                  <a href="#" class="btn_del_prestataire btn btn-sm btn-danger" data-id="<?=$prestataire['id'];?>">Supprimer</a>
                  <a href="#" id="btn_up_prestataire" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?= $prestataire['id']; ?>" class="btn btn-sm btn-warning"></i>Modifier</a>
               </td>
            </tr>
            <?php } 
               } else { ?>
                  <tr>
                     <td colspan="8" class="text-center">
                        <div class="alert alert-warning" role="alert">
                           Pas de prestataires enregistrés !!!
                        </div>
                     </td>
                  </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>
</div>

<script>// new DataTable('#Prestataire'); </script>