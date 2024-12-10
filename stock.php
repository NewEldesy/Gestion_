<?php include_once('header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h3 class="h3">Gestion Stocks</h3>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <!-- <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
                    Gérer Stock
                </a> -->
            </div>
        </div>
    </div>
    <div>
        <div id="result_stock"></div>
        <div id="affStock"></div>
    </div>
</main>

<!-- Modal Modification-->
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
<!-- Modal Modification-->

<?php include_once('footer.php');?>