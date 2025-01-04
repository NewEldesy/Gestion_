<?php include_once('header.php'); ?>


      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Gestion Vehicules</h3>
            <a href="#" id="addVehicule" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
              Nouveau Vehicule
            </a>
          </div>
          <div class="card-body">
            <div id="result_vehicule"></div>
            <div id="affVehicule"></div>
          </div>
        </div>

        <!-- Modal Ajout Véhicule -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Véhicule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="" method="POST">
                  <div class="mb-3">
                    <label for="nom" class="form-label">Nom Véhicule</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                    <div class="invalid-feedback">Veuillez renseigner le nom du véhicule.</div>
                  </div>
                  <button type="submit" id="btn_add_vehicule" class="btn btn-primary">Ajouter</button>
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
                <h5 class="modal-title" id="UpdateModal">Modification Véhicule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="vehicule_mod"></div>
                <button type="submit" id="btn_maj_vehicule" class="btn btn-primary">Modifier</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Modification Véhicule -->
        

<?php include_once('footer.php'); ?>