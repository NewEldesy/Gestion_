<?php include_once('header.php'); ?>


      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Gestion Produits</h3>
            <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
              Nouveau Produit
            </a>
          </div>
          <div class="card-body">
            <div id="result_produit"></div>
            <div id="aff_produit"></div>
          </div>
        </div>

        <!-- Modal Ajout -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST">
                  <div class="mb-3">
                    <label for="designation" class="form-label">Désignation</label>
                    <input type="text" class="form-control" id="designation" name="designation" required>
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
                    <label for="pu" class="form-label">Prix Unitaire</label>
                    <input type="text" class="form-control" id="pu" name="pu" required>
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                  </div>
                  <button type="submit" id="btn_add_produit" class="btn btn-primary">Ajouter</button>
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
                <h5 class="modal-title" id="UpdateModal">Modification Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="produit_mod"></div>
                <button type="submit" id="btn_maj_produit" class="btn btn-primary">Modifier</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Modification -->
        

<?php include_once('footer.php'); ?>
<script>
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