<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM vehicule");
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-12 order-md-1">
    <h5 class="mb-5">Liste de Véhicules</h5>
    <div class="table-responsive">
        <table id="Vehicule" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                        <th>Nom</th>
                        <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($vehicules)) {
                    foreach ($vehicules as $vehicule) { ?>
                <tr>
                    <td><?= htmlspecialchars($vehicule['id']); ?></td>
                    <td><?= htmlspecialchars($vehicule['nom']); ?></td>
                <td>
                    <a href="#" class="btn_del_vehicule btn btn-sm btn-danger" data-id="<?=$vehicule['id'];?>">Supprimer</a>
                    <a href="#" id="btn_up_vehicule" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?= $vehicule['id']; ?>" class="btn btn-sm btn-warning"></i>Modifier</a>
                </td>
                </tr>
                <?php } 
                } else { ?>
                    <tr>
                        <td colspan="3" class="text-center">
                            <div class="alert alert-warning" role="alert">
                            Pas de véhicules enregistrés !!!
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
      </table>
   </div>
</div>

<script> new DataTable('#Vehicule'); </script>