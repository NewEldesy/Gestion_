<?php include_once('header.php'); ?>


      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Gestion Prestataires</h3>
            <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
              Nouveau Prestataire
            </a>
          </div>
          <div class="card-body">
            <div id="result_prestataire"></div>
            <div id="affPrest"></div>
          </div>
        </div>

        <!-- Modal Ajout Véhicule -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Prestataire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
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
                  <button type="submit" id="btn_add_prestataire" class="btn btn-primary">Ajouter</button>
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
                <div id="prestataire_mod"></div>
                <button type="button" id="btn_maj_prestataire" class="btn btn-primary">Modifier</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Modification Véhicule -->
        

<?php include_once('footer.php'); ?>