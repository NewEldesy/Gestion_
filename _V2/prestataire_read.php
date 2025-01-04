<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM prestataire");
$prestataires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste des Prestataires</h5>
<table class="table align-middle mb-0 p-5" id="Prestataire">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">Nom</th>
            <th scope="col" class="text-center">Prénom</th>
            <th scope="col" class="text-center">Date Naissance</th>
            <th scope="col" class="text-center">Téléphone</th>
            <th scope="col" class="text-center">Téléphone 2</th>
            <th scope="col" class="text-center">Poste</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($prestataires)) {
                  foreach ($prestataires as $prestataire) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($prestataire['id']);?></th>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestataire['nom']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestataire['prenom']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestataire['date_naissance']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestataire['telephone']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestataire['telephone2']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestataire['poste']);?></td>
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

<script> new DataTable('#Prestataire'); </script>