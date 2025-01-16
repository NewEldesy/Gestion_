<?php include_once('header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2>Interface d'activation Logiciel</h2>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-3">
                        <h4 style="color: red;">Votre licence à expiré veuillez contactez B'Tech Group pour un renouvelement</h4>
                    </div>
                    <div class="mt-3">
                        <h5>Ou</h5>
                    </div>
                    <div id="result_vente"  class="mt-3 fw-bolder"></div>
                    <h4 class="mt-2">Activé Licence</h4>
                    <div class="mt-2">
                        <input type="text" id="licence" class="form-control" placeholder="Numéro Licence">
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-success mt-2" id="activeLicence">Activé</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--JavaScript -->
<?php include_once('footer.php'); ?>