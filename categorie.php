<?php include_once('header.php'); ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h3 class="h3">Categorie</h3>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="#" id="addCat" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-sm btn-outline-primary">
                                    Nouvelle Categorie
                                </a>
                            </div>
                        </div>
                    </div>

                    <div id="result_cat"></div> <!-- Ajouté pour afficher le résultat -->
                    <div id="msg_delete_cat"></div>
                    <div id="msg_maj_cat"></div>

                    <div id="affCat" class="m-5"></div>
                </main>

            </div>
        </div>
    
        <!-- Modal Modification categorie -->
        <div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="UpdateModal">Modifier Categorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" >
                        <div id="aff_form_mod"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_maj_cat" class="btn btn-primary">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Modification categorie -->

        <!-- Modal Ajout categorie -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddModal">Ajouter Categorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_add_cat" class="needs-validation" novalidates>
                            <label for="nom">Nom Categorie</label>
                            <input type="text" class="form-control" id="nom" name="nom">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_add_cat" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Ajout categorie -->

        <!-- JavaScript -->
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/dataTables/js/dataTables.js"></script>
    </body>
</html>