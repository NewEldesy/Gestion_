<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT * FROM prestations");
$stmt->execute();
$prestations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste des Prestations</h5>
<table class="table align-middle mb-0 p-5" id="Prestations">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">Désignation</th>
            <th scope="col" class="text-center">Prix</th>
            <th scope="col" class="text-center">Description</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($prestations)) {
            foreach ($prestations as $prestation) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($prestation['id']);?></th>
            <td class="text-center fw-medium"><?=htmlspecialchars($prestation['designation']);?></td>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($prestation['prix']);?> FCFA</th>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($prestation['description']);?></th>
            <td>
                <a href="#" class="btn_del_prestation btn btn-sm btn-danger" data-id="<?=$prestation['id'];?>">Supprimer</a>
                <a href="#" id="btn_up_prestation" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?=$prestation['id'];?>" class="btn btn-sm btn-warning"></i>Modifier</a>
            </td>
        </tr>
        <?php } 
            } else { ?>
                <tr>
                    <td colspan="5" class="text-center">
                    <div class="alert alert-warning" role="alert">
                        Pas de prestations enregistrés !!!
                    </div>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<script> new DataTable('#Prestations'); </script>