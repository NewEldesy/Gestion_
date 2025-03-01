<?php include_once('header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2>Interface d'activation Logiciel</h2>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="result_licence"  class="mt-3 fw-bolder"></div>
                    <h4 class="mt-2">Activation Logiciel</h4>
                    <div class="mt-2">
                        <pre>Saisisez la licence dans ce champs * </pre>
                        <input type="text" id="licence" class="form-control" placeholder="A1B2-C3D4-E5F6-G7H8" pattern="[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}" maxlength="19" oninput="formatLicence(this)" required>
                        <div id="loadingSpinner" style="display: none;">Chargement...</div>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-success mt-2" id="activeLicence">Activé</button>
                    </div>
                    <div class="mt-3">
                        <h4 style="color: red;">Si vous n'avez pas de clé d'activation logiciel, veuillez contactez B'Tech Group pour un renouvelement.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--JavaScript -->
<?php include_once('footer.php'); ?>