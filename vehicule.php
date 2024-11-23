<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM vehicule");
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des variables pour le modal de modification
$categorie = ['nom' => ''];
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Véhicules</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-sm btn-outline-primary">
                    Nouveau
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-5">Liste des Véhicules</h5>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-sm">
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
                                    <a href="vehicule_delete.php?id=<?= htmlspecialchars($vehicule['id']); ?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?= $vehicule['id']; ?>" data-nom="<?= htmlspecialchars($vehicule['nom']); ?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de véhicules enregistré !
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Ajout Véhicule -->
<div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Véhicule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="vehicule_add.php" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom Véhicule</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                        <div class="invalid-feedback">Veuillez renseigner le nom du véhicule.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ajout Véhicule -->

<!-- Modal Modification Véhicule -->
<div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateModal">Modifier Véhicule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="vehicule_update.php" method="POST">
                    <input type="hidden" name="id" id="vehicule_id">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom Véhicule</label>
                        <input type="text" class="form-control" id="vehicule_nom" name="nom" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Modification Véhicule -->

<!-- JavaScript -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dataTables/js/dataTables.js"></script>
<script>
    // Remplir les champs du modal "Modifier" avec les données
    var exampleModalMaj = document.getElementById('exampleModalMaj');
    exampleModalMaj.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nom = button.getAttribute('data-nom');

        // Remplir les champs cachés et visibles
        document.getElementById('vehicule_id').value = id;
        document.getElementById('vehicule_nom').value = nom;
    });
</script>
