<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->query("SELECT * FROM Mecaniques");
$Mecaniques = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Prestation Mécanique</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
                    Nouvelle Prestation Mécanique
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="mb-5">Liste des Prestation Mécanique</h5>
        <div class="table-responsive">
            <table id="productTable" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>N° Immatriculation</th>
                        <th>Marque Véhicule</th>
                        <th>Contact Propriétaire</th>
                        <th>Date Entrée</th>
                        <th>Date Sortie</th>
                        <th>Prestataire</th>
                        <th>Observation</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($Mecaniques)) {
                        foreach ($Mecaniques as $mecanique) { ?>
                            <tr>
                                <td><?=htmlspecialchars($mecanique['id']);?></td>
                                <td><?=htmlspecialchars($mecanique['num_immatriculation']);?></td>
                                <td><?=htmlspecialchars($mecanique['vehicule']);?></td>
                                <td><?=htmlspecialchars($mecanique['proprietaire_contact']);?></td>
                                <td><?=htmlspecialchars($mecanique['date_entree']);?></td>
                                <td><?=htmlspecialchars($mecanique['date_sortie']);?></td>
                                <td><?=htmlspecialchars($mecanique['prestataire']);?></td>
                                <td><?=htmlspecialchars($mecanique['observation']);?></td>
                                <td>
                                    <a href="vehicule_delete.php?id=<?=$mecanique['id'];?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$mecanique['id'];?>" data-num_immatriculation="<?=$mecanique['num_immatriculation'];?>" data-vehicule="<?=$mecanique['vehicule'];?>" data-proprietaire_contact="<?=$mecanique['proprietaire_contact'];?>" data-date_entree="<?=$mecanique['date_entree'];?>" data-date_sortie="<?=$mecanique['date_sortie'];?>" data-prestataire="<?=$mecanique['prestataire'];?>" data-observation="<?=$mecanique['observation'];?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de Prestations Mécaniques enregistré !
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
                <h5 class="modal-title" id="AddModal">Enregistrement Prestation Mécanique</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="PrestationM_add.php" method="POST">
                    <div class="mb-3">
                        <label for="immatriculation" class="form-label">N° Immatriculation</label>
                        <input type="text" class="form-control" id="immatriculation" name="immatriculation" required>
                        <br>
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <input type="text" class="form-control" id="vehicule" name="vehicule" required>
                        <br>
                        <label for="proprietaire_contact" class="form-label">Contact Propriétaire</label>
                        <input type="text" class="form-control" id="proprietaire_contact" name="proprietaire_contact" required>
                        <br>
                        <label for="date_entree" class="form-label">Date Entrée</label>
                        <input type="date" class="form-control" id="date_entree" name="date_entree" required>
                        <br>
                        <label for="date_sortie" class="form-label">Date Sortie</label>
                        <input type="date" class="form-control" id="date_sortie" name="date_sortie" required>
                        <br>
                        <label for="prestataire" class="form-label">Prestataire</label>
                        <input type="text" class="form-control" id="prestataire" name="prestataire" required>
                        <br>
                        <label for="observation" class="form-label">Observation</label>
                        <input type="text" class="form-control" id="observation" name="observation" required>
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
                <h5 class="modal-title" id="UpdateModal">Modifier Prestation Mécanique</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestationM_update.php" method="POST">
                    <input type="hidden" name="id" id="PM_id">
                    <div class="mb-3">
                        <label for="immatriculation" class="form-label">N° Immatriculation</label>
                        <input type="text" class="form-control" id="PM_num_immatriculation" name="immatriculation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <input type="text" class="form-control" id="PM_vehicule" name="vehicule" required>
                    </div>
                    <div class="mb-3">
                        <label for="proprietaire_contact" class="form-label">Contact Propriétaire</label>
                        <input type="text" class="form-control" id="PM_proprietaire_contact" name="proprietaire_contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_entree" class="form-label">Date Entrée</label>
                        <input type="date" class="form-control" id="PM_date_entree" name="date_entree" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_sortie" class="form-label">Date Sortie</label>
                        <input type="date" class="form-control" id="PM_date_sortie" name="date_sortie" required>
                    </div>
                    <div class="mb-3">
                        <label for="prestataire" class="form-label">Prestataire</label>
                        <input type="text" class="form-control" id="PM_prestataire" name="prestataire" required>
                    </div>
                    <div class="mb-3">
                        <label for="observation" class="form-label">Observation</label>
                        <input type="text" class="form-control" id="PM_observation" name="observation" required>
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
        var num_immatriculation = button.getAttribute('data-num_immatriculation');
        var vehicule = button.getAttribute('data-vehicule');
        var proprietaire_contact = button.getAttribute('data-proprietaire_contact');
        var date_entree = button.getAttribute('data-date_entree');
        var date_sortie = button.getAttribute('data-date_sortie');
        var prestataire = button.getAttribute('data-prestataire');
        var observation = button.getAttribute('data-observation');

        // Remplir les champs cachés et visibles
        document.getElementById('PM_id').value = id;
        document.getElementById('PM_num_immatriculation').value = num_immatriculation;
        document.getElementById('PM_vehicule').value = vehicule;
        document.getElementById('PM_proprietaire_contact').value = proprietaire_contact;
        document.getElementById('PM_date_entree').value = date_entree;
        document.getElementById('PM_date_sortie').value = date_sortie;
        document.getElementById('PM_prestataire').value = prestataire;
        document.getElementById('PM_observation').value = observation;
    });
</script>