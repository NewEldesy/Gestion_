<?php include_once('header.php'); ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h3 class="h3">Vente</h3>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <!-- <div class="btn-group mr-2">
                                <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-sm btn-outline-primary">
                                    Enregistrer et Imprimer
                                </a>
                            </div> -->
                        </div>
                    </div>
                    <div class="container mt-4">
                        <h2>Interface de Vente</h2>
                        <div class="row">
                            <!-- Liste des produits -->
                            <div class="col-md-6">
                                <h4>Produits</h4>
                                <select id="produit" class="form-select">
                                    <option value="">Sélectionnez un produit</option>
                                </select>
                                <div class="mt-2">
                                    <input type="number" id="quantite" class="form-control" placeholder="Quantité disponible du produit" readonly>
                                </div>
                                <div class="mt-2">
                                    <input type="number" id="quantite" class="form-control" placeholder="Quantité" min="1">
                                    <button class="btn btn-primary mt-2" id="ajouterProduit">Ajouter</button>
                                </div>
                            </div>

                            <!-- Panier -->
                            <div class="col-md-6">
                                <h4>Panier</h4>
                                <table class="table table-bordered" id="panierTable">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix Unitaire</th>
                                            <th>Quantité</th>
                                            <th>Sous-total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="mb-3">
                                    <label for="remise" class="form-label">Remise (en %)</label>
                                    <input type="text" class="form-control" id="remise" placeholder="Exemple : 5 ou 10%">
                                </div>
                                <h5>Total : <span id="total">0.00</span> €</h5>
                                <button class="btn btn-success" id="imprimer">Imprimer le reçu</button>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        <!--JavaScript -->
        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/dataTables/js/dataTables.js"></script>
        <script src="assets/jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                let panier = [];
                let total = 0;

                // Charger les produits depuis la base de données (AJAX)
                function chargerProduits() {
                    $.ajax({
                        url: 'getProduits.php', // Endpoint pour récupérer les produits
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#produit').empty().append('<option value="">Sélectionnez un produit</option>');
                            data.forEach(function(produit) {
                                $('#produit').append(`<option value="${produit.id}" data-prix="${produit.prix}">${produit.nom}</option>`);
                            });
                        }
                    });
                }
                chargerProduits();

                // Ajouter un produit au panier
                $('#ajouterProduit').click(function() {
                    const produitId = $('#produit').val();
                    const produitNom = $('#produit option:selected').text();
                    const produitPrix = parseFloat($('#produit option:selected').data('prix'));
                    const quantite = parseInt($('#quantite').val());

                    if (!produitId || quantite <= 0) {
                        alert('Veuillez sélectionner un produit et une quantité valide.');
                        return;
                    }

                    const sousTotal = produitPrix * quantite;
                    panier.push({ produitId, produitNom, produitPrix, quantite, sousTotal });
                    total += sousTotal;

                    // Ajouter au tableau
                    $('#panierTable tbody').append(`
                        <tr data-id="${produitId}">
                            <td>${produitNom}</td>
                            <td>${produitPrix.toFixed(2)} €</td>
                            <td>${quantite}</td>
                            <td>${sousTotal.toFixed(2)} €</td>
                            <td><button class="btn btn-danger btn-sm supprimer">Supprimer</button></td>
                        </tr>
                    `);

                    $('#total').text(total.toFixed(2));
                    $('#quantite').val('');
                });

                // Supprimer un produit du panier
                $('#panierTable').on('click', '.supprimer', function() {
                    const tr = $(this).closest('tr');
                    const produitId = tr.data('id');
                    const sousTotal = parseFloat(tr.find('td:nth-child(4)').text());

                    // Mettre à jour le total et le panier
                    total -= sousTotal;
                    panier = panier.filter(item => item.produitId !== produitId);

                    tr.remove();
                    $('#total').text(total.toFixed(2));
                });

                // Imprimer le reçu
                $('#imprimer').click(function() {
                    const venteData = {panier, total};

                    // Envoyer la vente au backend pour enregistrement et impression
                    $.ajax({
                        url: 'saveVente.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(venteData),
                        success: function(response) {
                            alert('Vente enregistrée avec succès !');
                            // Réinitialiser le panier
                            panier = [];
                            total = 0;
                            $('#panierTable tbody').empty();
                            $('#total').text('0.00');
                        }
                    });
                });
            });
        </script>
    </body>
</html>