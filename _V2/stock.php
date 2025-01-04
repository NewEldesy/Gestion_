<?php include_once('header.php'); ?>


      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Gestion Stocks</h3>
            <!-- <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
              Nouveau Prestataire
            </a> -->
          </div>
          <div class="card-body">
            <div id="result_stock"></div>
            <div id="affStock"></div>
          </div>
        </div>

        <!-- Modal Modification Véhicule -->
        <div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="UpdateModal">Modification Stock Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="stock_mod"></div>
                <button type="submit" id="btn_maj_stock" class="btn btn-primary">Modifier</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Modification Véhicule -->
        

<?php include_once('footer.php'); ?>