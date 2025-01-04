<?php include_once('header.php'); ?>


      <div class="container-fluid w-2550">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Gestion Prestation Mécanique</h3>
            <a href="#" id="addPM" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
              Nouvelle Prestation Mécanique
            </a>
          </div>
          <div class="card-body">
            <div id="result_pm"></div>
            <div id="affPM"></div>
          </div>
        </div>

        <!-- Modal Ajout -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Prestation Mécanique</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST">
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
                    <label for="montant" class="form-label">Montant Prestation</label>
                    <input type="number" class="form-control" id="montant" name="montant" required>
                  </div>
                  <div class="mb-3">
                    <label for="proprietaire_contact" class="form-label">Contact Propriétaire</label>
                    <input type="text" class="form-control" id="proprietaire_contact" name="proprietaire_contact" required>
                  </div>
                  <div class="mb-3">
                    <label for="date_entree" class="form-label">Date Entrée</label>
                    <input type="date" class="form-control" id="date_entree" name="date_entree" required>
                  </div>
                  <div class="mb-3">
                    <label for="date_sortie" class="form-label">Date Sortie</label>
                    <input type="date" class="form-control" id="date_sortie" name="date_sortie" required>
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
                  <button type="submit" id="btn_add_pm" class="btn btn-primary">Ajouter</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Ajout -->

        <!-- Modal Modification -->
        <div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="UpdateModal">Modification Prestation Mécanique</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="pm_mod"></div>
                <button type="submit" id="btn_maj_pm" class="btn btn-primary">Modifier</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Modification -->
        

<?php include_once('footer.php'); ?>