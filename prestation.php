<?php include_once('header.php'); ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h3 class="h3">Gestion Prestation</h3>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="#" id="addProd" class="btn btn-sm btn-outline-primary">
                                    Mécanique
                                </a>
                                <a href="#" id="addProd" class="btn btn-sm btn-outline-primary">
                                    Tractage
                                </a>
                                <a href="#" id="addProd" class="btn btn-sm btn-outline-primary">
                                    Autre
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- <div>
                        <h5 class="mb-5">Liste des Produits</h5>
                        <div class="table-responsive">
                            <table id="productTable" class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Prx</th>
                                    <th>img</th>
                                    <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php // if (!empty($prods)) {
                                        // foreach ($prods as $prod) { ?>
                                    <tr>
                                    <td><?// = $prod['id']; ?></td>
                                    <td><?// = $prod['nom']; ?></td>
                                    <td><?// = $prod['prix']; ?></td>
                                    <td><img src="assets/img/<?// =$prod['img'];?>" alt="" width="40" height="40"></td>
                                    <td>
                                        <a href="#" class="btn_del_prod btn btn-sm btn-danger" data-id="<?=$prod['id'];?>">Supprimer</a>
                                        <a href="#" id="btn_up_prod" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?= $prod['id']; ?>" class="btn btn-sm btn-warning"></i>Modifier</a>
                                    </td>
                                    </tr>
                                    <?php // } 
                                    // } else { ?>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <div class="alert alert-warning" role="alert">
                                                Pas de produits disponible
                                                </div>
                                            </td>
                                        </tr>
                                    <?php // } ?>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                </main>
            </div>
        </div>

        <!--JavaScript -->
        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/dataTables/js/dataTables.js"></script>
    </body>
</html>