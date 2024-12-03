<?php
include_once('header.php');
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT a.id, a.num_immatriculation, a.vehicule, a.contact_proprietaire, a.type_prestation, a.montant, a.date_entree, 
    a.prestataire, a.observation, v.nom AS vehicule_nom, p.nom AS prestataire_nom, p.prenom AS prestataire_prenom FROM AutreP a
    LEFT JOIN vehicule v ON a.vehicule = v.id
    LEFT JOIN prestataire p ON a.prestataire = p.id");
$stmt->execute();
$PAS = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Produits</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
                    Autre Prestation
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
                        <th>N° Immatriculation</th>
                        <th>Marque Véhicule</th>
                        <th>Contact Propriétaire</th>
                        <th>Type Prestation</th>
                        <th>Montant</th>
                        <th>Date Prestation</th>
                        <th>Prestataire</th>
                        <th>Observation</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($PAS)) {
                        foreach ($PAS as $pa) { ?>
                            <tr>
                                <td><?=htmlspecialchars($pa['id']);?></td>
                                <td><?=htmlspecialchars($pa['num_immatriculation']);?></td>
                                <td><?=htmlspecialchars($pa['vehicule_nom']);?></td>
                                <td><?=htmlspecialchars($pa['contact_proprietaire']);?></td>
                                <td><?=htmlspecialchars($pa['type_prestation']);?></td>
                                <td><?=htmlspecialchars($pa['montant']);?> FCFA</td>
                                <td><?=htmlspecialchars($pa['date_entree']);?></td>
                                <td><?=htmlspecialchars($pa['prestataire_nom']);?> <?=htmlspecialchars($pa['prestataire_prenom']);?></td>
                                <td><?=htmlspecialchars($pa['observation']);?></td>
                                <td>
                                    <a href="prestationA_delete.php?id=<?=htmlspecialchars($pa['id']);?>" class="btn btn-sm btn-danger">Supprimer</a>
                                    <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" data-id="<?=$pa['id'];?>" data-num_immatriculation="<?=htmlspecialchars($pa['num_immatriculation']);?>" data-vehicule="<?=htmlspecialchars($pa['vehicule']);?>" data-contact_proprietaire="<?=htmlspecialchars($pa['contact_proprietaire']);?>" data-type_prestation="<?=htmlspecialchars($pa['type_prestation']);?>" data-montant="<?=htmlspecialchars($pa['montant']);?>" data-date_entree="<?=htmlspecialchars($pa['date_entree']);?>" data-prestataire="<?=htmlspecialchars($pa['prestataire']);?>" data-observation="<?=htmlspecialchars($pa['observation']);?>">Modifier</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="10" class="text-center">
                                <div class="alert alert-warning" role="alert">
                                    Pas de prestations enregistré !
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
                <h5 class="modal-title" id="AddModal">Enregistrement Prestation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestationA_add.php" method="POST">
                    <div class="mb-3">
                        <label for="num_immatriculation" class="form-label">N° Immatriculation</label>
                        <input type="text" class="form-control" id="num_immatriculation" name="num_immatriculation" required>
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
                        <label for="contact_proprietaire" class="form-label">Contact Propriétaire</label>
                        <input type="text" class="form-control" id="contact_proprietaire" name="contact_proprietaire" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_prestation" class="form-label">Type Prestation</label>
                        <input type="text" class="form-control" id="type_prestation" name="type_prestation" required>
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_entree" class="form-label">Date Prestation</label>
                        <input type="date" class="form-control" id="date_entree" name="date_entree" required>
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
                <h5 class="modal-title" id="UpdateModal">Modifier Prestation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="prestationA_update.php" method="POST">
                    <input type="hidden" name="id" id="PA_id">
                    <div class="mb-3">
                        <label for="num_immatriculation" class="form-label">N° Immatriculation</label>
                        <input type="text" class="form-control" id="PA_num_immatriculation" name="num_immatriculation" required>
                    </div>
                    <div class="mb-3">
                        <label for="vehicule" class="form-label">Marque Véhicule</label>
                        <select id="PA_vehicule" name="vehicule" class="form-select">
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
                        <label for="contact_proprietaire" class="form-label">Contact Propriétaire</label>
                        <input type="text" class="form-control" id="PA_contact_proprietaire" name="contact_proprietaire" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_prestation" class="form-label">Type Prestation</label>
                        <input type="text" class="form-control" id="PA_type_prestation" name="type_prestation" required>
                    </div>
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="PA_montant" name="montant" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_entree" class="form-label">Date Prestation</label>
                        <input type="date" class="form-control" id="PA_date_entree" name="date_entree" required>
                    </div>
                    <div class="mb-3">
                        <label for="prestataire" class="form-label">Prestataire</label>
                        <select id="PA_prestataire" name="prestataire" class="form-select">
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
                        <textarea class="form-control" id="PA_observation" name="observation" rows="3" required></textarea>
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
        var contact_proprietaire = button.getAttribute('data-contact_proprietaire');
        var type_prestation = button.getAttribute('data-type_prestation');
        var montant = button.getAttribute('data-montant');
        var date_entree = button.getAttribute('data-date_entree');
        var prestataire = button.getAttribute('data-prestataire');
        var observation = button.getAttribute('data-observation');

        // Remplir les champs cachés et visibles
        document.getElementById('PA_id').value = id;
        document.getElementById('PA_num_immatriculation').value = num_immatriculation;
        document.getElementById('PA_vehicule').value = vehicule;
        document.getElementById('PA_contact_proprietaire').value = contact_proprietaire;
        document.getElementById('PA_type_prestation').value = type_prestation;
        document.getElementById('PA_montant').value = montant;
        document.getElementById('PA_date_entree').value = date_entree;
        document.getElementById('PA_prestataire').value = prestataire;
        document.getElementById('PA_observation').value = observation;
    });
</script>