<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM prestataire");
$prestataires = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des variables pour le modal de modification
$categorie = ['nom' => ''];
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Prestataires</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
                    Nouveau Prestataire
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-5">Liste de Prestataires</h5>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-sm">
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
                                    <a href="prestataire_delete.php?id=<?=$prestataire['id'];?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$prestataire['id'];?>" data-nom="<?=$prestataire['nom'];?>" data-prenom="<?=$prestataire['prenom'];?>" data-date_naissance="<?=$prestataire['date_naissance'];?>" data-telephone="<?=$prestataire['telephone'];?>" data-telephone2="<?=$prestataire['telephone2'];?>" data-poste="<?=$prestataire['poste'];?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de prestataires enregistré !
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
                <h5 class="modal-title" id="AddModal">Enregistrement Prestataire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestataire_add.php" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">prenom *</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_naissance" class="form-label">Date de naissance *</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone *</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone2" class="form-label">Téléphone 2</label>
                        <input type="text" class="form-control" id="telephone2" name="telephone2">
                    </div>
                    <div class="mb-3">
                        <label for="poste" class="form-label">Poste *</label>
                        <input type="text" class="form-control" id="poste" name="poste" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
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
                <h5 class="modal-title" id="UpdateModal">Modification Prestataire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestataire_update.php" method="POST">
                    <input type="hidden" name="id" id="prestataire_id">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control" id="prestataire_nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" class="form-control" id="prestataire_prenom" name="prenom" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_naissance" class="form-label">Date de Naissance *</label>
                        <input type="date" class="form-control" id="prestataire_date_naissance" name="date_naissance" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone *</label>
                        <input type="text" class="form-control" id="prestataire_telephone" name="telephone" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone2" class="form-label">Téléphone2</label>
                        <input type="text" class="form-control" id="prestataire_telephone2" name="telephone2">
                    </div>
                    <div class="mb-3">
                        <label for="poste" class="form-label">Poste *</label>
                        <input type="text" class="form-control" id="prestataire_poste" name="poste" required>
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
        var prenom = button.getAttribute('data-prenom');
        var date_naissance = button.getAttribute('data-date_naissance');
        var telephone = button.getAttribute('data-telephone');
        var telephone2 = button.getAttribute('data-telephone2');
        var poste = button.getAttribute('data-poste');

        // Remplir les champs cachés et visibles
        document.getElementById('prestataire_id').value = id;
        document.getElementById('prestataire_nom').value = nom;
        document.getElementById('prestataire_prenom').value = prenom;
        document.getElementById('prestataire_date_naissance').value = date_naissance;
        document.getElementById('prestataire_telephone').value = telephone;
        document.getElementById('prestataire_telephone2').value = telephone2;
        document.getElementById('prestataire_poste').value = poste;
    });
</script>