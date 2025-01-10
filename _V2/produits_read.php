<?php
include_once('model.php');
$database = dbConnect();

$stmt = $database->prepare("SELECT * FROM produits");
$stmt->execute(); $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste des Produits</h5>
<table class="table align-middle mb-0 p-5" id="Prod">
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
        <?php if (!empty($produits)) {
            foreach ($produits as $produit) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($produit['id']);?></th>
            <td class="text-center fw-medium"><?=htmlspecialchars($produit['designation']);?></td>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($produit['pu']);?> FCFA</th>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($produit['description']);?></th>
            <td>
                <a href="#" class="btn_del_produit btn btn-sm btn-danger" data-id="<?=$produit['id'];?>">Supprimer</a>
                <a href="#" id="btn_up_produit" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?=$produit['id'];?>" class="btn btn-sm btn-warning"></i>Modifier</a>
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

<script> new DataTable('#Prod'); </script>