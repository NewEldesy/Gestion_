<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM produits");
$Produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des variables pour le modal de modification
$categorie = ['nom' => ''];
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Produits</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
                    Nouveau Produit
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-5">Liste des Produits</h5>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-sm">
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
                    <?php if (!empty($Produits)) {
                        foreach ($Produits as $produit) { ?>
                            <tr>
                                <td><?=htmlspecialchars($produit['id']);?></td>
                                <td><?=htmlspecialchars($produit['designation']);?></td>
                                <td><?=htmlspecialchars($produit['vehicule']);?></td>
                                <td><?=htmlspecialchars($produit['pu']);?> FCFA</td>
                                <td><?=htmlspecialchars($produit['description']);?></td>
                                <td>
                                    <a href="produits_delete.php?id=<?=$produit['id'];?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$produit['id'];?>" data-designation="<?=$produit['designation'];?>" data-vehicule="<?=$produit['vehicule'];?>" data-description="<?=$produit['description'];?>" data-prixunitaire="<?=$produit['pu'];?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">
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
                <form action="produits_add.php" method="POST">
                    <div class="mb-3">
                        <label for="designation" class="form-label">Désignation</label>
                        <input type="text" class="form-control" id="designation" name="designation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <select id="vehicule" class="form-select">
                            <option value="">Sélectionnez un Vehicule</option>
                            <?php 
                                $vehicules = getVehicule();
                                foreach($vehicules as $vehicule) {
                            ?>
                            <option value="<?=$vehicule['id'];?>"><?=$vehicule['nom'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pu" class="form-label">Prix Unitaire</label>
                        <input type="text" class="form-control" id="pu" name="pu" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
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
                <h5 class="modal-title" id="UpdateModal">Modification Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="produits_update.php" method="POST">
                    <input type="hidden" name="id" id="produit_id">
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="produit_designation" name="designation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <select id="vehicule" class="form-select">
                            <option value="">Sélectionnez un Vehicule</option>
                            <?php 
                                $vehicules = getVehicule();
                                foreach($vehicules as $vehicule) {
                            ?>
                            <option value="<?=$vehicule['id'];?>"><?=$vehicule['nom'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prixunitaire" class="form-label">Prix Unitaire</label>
                        <input type="text" class="form-control" id="produit_prixunitaire" name="prixunitaire" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="produit_description" name="description" rows="3" required></textarea>
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
        var prixunitaire = button.getAttribute('data-prixunitaire');
        var description = button.getAttribute('data-description');

        // Remplir les champs cachés et visibles
        document.getElementById('produit_id').value = id;
        document.getElementById('produit_designation').value = designation;
        document.getElementById('produit_vehicule').value = vehicule;
        document.getElementById('produit_prixunitaire').value = prixunitaire;
        document.getElementById('produit_description').value = description;
    });

    $(document).ready(function () {
        // Charger les véhicules depuis la base de données (AJAX)
        function chargerVehicules() {
            $.ajax({
                url: 'getVehicules.php', // Endpoint pour récupérer les véhicules
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#vehicule').empty().append('<option value="">Sélectionnez un véhicule</option>');
                    data.forEach(function (vehicule) {
                        // Ajout des véhicules dans les options avec des attributs pour id et marque
                        $('#vehicule').append(
                            `<option value="${vehicule.id}"">
                                ${vehicule.nom}
                            </option>`
                        );
                    });
                }
            });
        }

        chargerVehicules();

        // Récupérer la marque du véhicule sélectionné
        $('#vehicule').on('change', function () {
            const id = $('#vehicule option:selected').data('id');
            if (id) {
                alert('Marque du véhicule sélectionné : ' + id);
            } else {
                alert('Veuillez sélectionner un véhicule.');
            }
        });
    });
</script>