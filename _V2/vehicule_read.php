<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM vehicule");
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste de Véhicules</h5>
<table class="table align-middle mb-0 p-5" id="Vehicule">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">Nom</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($vehicules)) {
            foreach ($vehicules as $vehicule) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?= htmlspecialchars($vehicule['id']);?></th>
            <td class="text-center fw-medium"><?= htmlspecialchars($vehicule['nom']);?></td>
            <td>
                <a href="#" class="btn_del_vehicule btn btn-sm btn-danger" data-id="<?=$vehicule['id'];?>">Supprimer</a>
                <a href="#" id="btn_up_vehicule" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?=$vehicule['id'];?>" class="btn btn-sm btn-warning"></i>Modifier</a>
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

<script> new DataTable('#Vehicule'); </script>