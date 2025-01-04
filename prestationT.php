<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT t.id, t.date_entree, t.vehicule, t.num_immatriculation, t.proprietaire_contact, t.lieu_kilometrage, t.montant, 
    t.prestataire, t.observation, v.nom AS vehicule_nom, p.nom AS prestataire_nom, p.prenom AS prestataire_prenom FROM Tractage t
    LEFT JOIN vehicule v ON t.vehicule = v.id
    LEFT JOIN prestataire p ON t.prestataire = p.id");
$stmt->execute();
$tractages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Prestations Tractage</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
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
                        <th>Date Tractage</th>
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
                                <td><?=htmlspecialchars($tractage['vehicule_nom']);?></td>
                                <td><?=htmlspecialchars($tractage['proprietaire_contact']);?></td>
                                <td><?=htmlspecialchars($tractage['lieu_kilometrage']);?></td>
                                <td><?=htmlspecialchars($tractage['date_entree']);?></td>
                                <td><?=htmlspecialchars($tractage['montant']);?></td>
                                <td><?=htmlspecialchars($tractage['prestataire_nom']);?> <?=htmlspecialchars($tractage['prestataire_prenom']);?></td>
                                <td><?=htmlspecialchars($tractage['observation']);?></td>
                                <td>
                                    <a href="prestationT_delete.php?id=<?=$tractage['id'];?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$tractage['id'];?>" data-num_immatriculation="<?=$tractage['num_immatriculation'];?>" data-vehicule="<?=$tractage['vehicule'];?>" data-proprietaire_contact="<?=$tractage['proprietaire_contact'];?>" data-lieu_kilometrage="<?=$tractage['lieu_kilometrage'];?>" data-date_entree="<?=$tractage['date_entree'];?>" data-montant="<?=$tractage['montant'];?>"  data-prestataire="<?=$tractage['prestataire'];?>"  data-observation="<?=$tractage['observation'];?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de Prestation de Tractage enregistré !
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
                <h5 class="modal-title" id="AddModal">Enregistrement Prestation Tractage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestationT_add.php" method="POST">
                    <div class="mb-3">
                        <label for="immatriculation" class="form-label">N° Immatriculation</label>
                        <input type="text" class="form-control" id="immatriculation" name="immatriculation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <select id="vehicule" name="vehicule" class="form-select">
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
                        <label for="proprietaire_contact" class="form-label">Contact Propriétaire</label>
                        <input type="text" class="form-control" id="proprietaire_contact" name="proprietaire_contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="lieu_kilometrage" class="form-label">Lieu Kilometrage</label>
                        <input type="text" class="form-control" id="lieu_kilometrage" name="lieu_kilometrage" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_entree" class="form-label">Date Tractage</label>
                        <input type="date" class="form-control" id="date_entree" name="date_entree" required>
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant Prestation</label>
                        <input type="number" class="form-control" id="montant" name="montant" required>
                    </div>
                    <div class="mb-3">
                        <label for="prestataire" class="form-label">Prestataire</label>
                        <select id="prestataire" name="prestataire" class="form-select">
                            <option value="">Sélectionnez un Prestataire</option>
                            <?php 
                                $vehicules = getPrestataire();
                                foreach($vehicules as $vehicule) {
                            ?>
                            <option value="<?=$vehicule['id'];?>"><?=$vehicule['nom'];?> <?=$vehicule['prenom'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="observation" class="form-label">Observation</label>
                        <textarea class="form-control" id="observation" name="observation" rows="3" required></textarea>
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
                <h5 class="modal-title" id="UpdateModal">Modification Prestation Tractage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestationT_update.php" method="POST">
                    <input type="hidden" name="id" id="PT_id">
                    <div class="mb-3">
                        <label for="immatriculation" class="form-label">N° Immatriculation</label>
                        <input type="text" class="form-control" id="PT_num_immatriculation" name="immatriculation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <select id="PT_vehicule" name="vehicule" class="form-select">
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
                        <label for="proprietaire_contact" class="form-label">Contact Propriétaire</label>
                        <input type="text" class="form-control" id="PT_proprietaire_contact" name="proprietaire_contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="lieu_kilometrage" class="form-label">Lieu Kilometrage</label>
                        <input type="text" class="form-control" id="PT_lieu_kilometrage" name="lieu_kilometrage" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_entree" class="form-label">Date Tractage</label>
                        <input type="date" class="form-control" id="PT_date_entree" name="date_entree" required>
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant Prestation</label>
                        <input type="text" class="form-control" id="PT_montant" name="montant" required>
                    </div>
                    <div class="mb-3">
                        <label for="prestataire" class="form-label">Prestataire</label>
                        <select id="PT_prestataire" name="prestataire" class="form-select">
                            <option value="">Sélectionnez un Prestataire</option>
                            <?php 
                                $vehicules = getPrestataire();
                                foreach($vehicules as $vehicule) {
                            ?>
                            <option value="<?=$vehicule['id'];?>"><?=$vehicule['nom'];?> <?=$vehicule['prenom'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="observation" class="form-label">Observation</label>
                        <textarea class="form-control" id="PT_observation" name="observation" rows="3" required></textarea>
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
        var lieu_kilometrage = button.getAttribute('data-lieu_kilometrage');
        var date_entree = button.getAttribute('data-date_entree');
        var montant = button.getAttribute('data-montant');
        var prestataire = button.getAttribute('data-prestataire');
        var observation = button.getAttribute('data-observation');

        // Remplir les champs cachés et visibles
        document.getElementById('PT_id').value = id;
        document.getElementById('PT_num_immatriculation').value = num_immatriculation;
        document.getElementById('PT_vehicule').value = vehicule;
        document.getElementById('PT_proprietaire_contact').value = proprietaire_contact;
        document.getElementById('PT_lieu_kilometrage').value = lieu_kilometrage;
        document.getElementById('PT_date_entree').value = date_entree;
        document.getElementById('PT_montant').value = montant;
        document.getElementById('PT_prestataire').value = prestataire;
        document.getElementById('PT_observation').value = observation;
    });
</script>