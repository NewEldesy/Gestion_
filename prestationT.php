<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM Tractage");
$tractages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des variables pour le modal de modification
$categorie = ['nom' => ''];
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Prestations Tractage</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-sm btn-outline-primary">
                    Nouvelle Prestation Tractage
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-5">Liste des Prestations Tractage</h5>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>N° Immatriculation</th>
                        <th>Marque Véhicule</th>
                        <th>Contact Propriétaire</th>
                        <th>Lieu</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Prestataire</th>
                        <th>Observation</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tractages)) {
                        foreach ($tractages as $tractage) { ?>
                            <tr>
                                <td><?=htmlspecialchars($tractage['id']);?></td>
                                <td><?=htmlspecialchars($tractage['num_immatriculation']);?></td>
                                <td><?=htmlspecialchars($tractage['vehicule']);?></td>
                                <td><?=htmlspecialchars($tractage['proprietaire_contact']);?></td>
                                <td><?=htmlspecialchars($tractage['lieu_kilometrage']);?></td>
                                <td><?=htmlspecialchars($tractage['date_entree']);?></td>
                                <td><?=htmlspecialchars($tractage['montant']);?></td>
                                <td><?=htmlspecialchars($tractage['prestataire']);?></td>
                                <td><?=htmlspecialchars($tractage['observation']);?></td>
                                <td>
                                    <a href="vehicule_delete.php?id=<?=htmlspecialchars($tractage['id']);?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$tractage['id'];?>" data-num_immatriculation="<?=htmlspecialchars($tractage['num_immatriculation']);?>" data-vehicule="<?=htmlspecialchars($tractage['vehicule']);?>" data-proprietaire_contact="<?=htmlspecialchars($tractage['proprietaire_contact']);?>" data-lieu_kilometrage="<?=htmlspecialchars($tractage['lieu_kilometrage']);?>" data-date_entree="<?=htmlspecialchars($tractage['date_entree']);?>" data-montant="<?=htmlspecialchars($tractage['montant']);?>"  data-prestataire="<?=htmlspecialchars($tractage['prestataire']);?>"  data-observation="<?=htmlspecialchars($tractage['observation']);?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de produits enregistré !
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
                <h5 class="modal-title" id="AddModal">Enregistrement Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="vehicule_add.php" method="POST">
                    <div class="mb-3">
                        <label for="deignation" class="form-label">Désignation</label>
                        <input type="text" class="form-control" id="deignation" name="deignation" required>
                        <br>
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <input type="text" class="form-control" id="vehicule" name="vehicule" required>
                        <div class="invalid-feedback">Veuillez renseigner le nom du véhicule.</div>
                        <br>
                        <label for="quantite" class="form-label">Quantité Produit</label>
                        <input type="text" class="form-control" id="quantite" name="quantite" required>
                        <div class="invalid-feedback">Veuillez renseigner le nom du véhicule.</div>
                        <br>
                        <label for="pu" class="form-label">Prix Unitaire</label>
                        <input type="text" class="form-control" id="pu" name="pu" required>
                        <div class="invalid-feedback">Veuillez renseigner les champs.</div>
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
                <h5 class="modal-title" id="UpdateModal">Modifier Véhicule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="vehicule_update.php" method="POST">
                    <input type="hidden" name="id" id="produit_id">
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="produit_designation" name="designation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <input type="text" class="form-control" id="produit_vehicule" name="vehicule" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" class="form-control" id="produit_quantite" name="quantite" required>
                    </div>
                    <div class="mb-3">
                        <label for="lieu_kilometrage" class="form-label">Prix Unitaire</label>
                        <input type="text" class="form-control" id="produit_prixunitaire" name="prixunitaire" required>
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
        var designation = button.getAttribute('data-designation');
        var vehicule = button.getAttribute('data-vehicule');
        var quantite = button.getAttribute('data-quantite');
        var prixunitaire = button.getAttribute('data-prixunitaire');

        // Remplir les champs cachés et visibles
        document.getElementById('produit_id').value = id;
        document.getElementById('produit_designation').value = designation;
        document.getElementById('produit_vehicule').value = vehicule;
        document.getElementById('produit_quantite').value = quantite;
        document.getElementById('produit_prixunitaire').value = prixunitaire;
    });
</script>