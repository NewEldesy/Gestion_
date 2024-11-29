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
                                    <input type="number" id="quantite_produit" class="form-control" placeholder="Quantité disponible du produit" readonly>
                                </div>
                                <div id="quantiteFeedback" class="invalid-feedback"></div>
                                <div class="mt-2">
                                    <input type="number" id="quantite" class="form-control" placeholder="Quantité" min="1">
                                    <button class="btn btn-primary mt-2" id="ajouterProduit">Ajouter</button>
                                </div>
                            </div>
                            <!-- Panier -->
                            <div class="col-md-6">
                                <h4>Facture N° : <span id="lastId"></span></h4>
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
                                    <input type="number" class="form-control" id="remise" min="5" placeholder="Exemple : 5 ou 10%">
                                </div>
                                <h5>Total : <span id="total">0.00</span> FCFA</h5>
                                <button class="btn btn-success" id="imprimer">Imprimer la Facture</button>
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

        <!-- <script>
            $(document).ready(function () {
                let panier = [];
                let total = 0;

                // Charger les produits depuis la base de données (AJAX)
                function chargerProduits() {
                    $.ajax({
                        url: 'getProduits.php', // Endpoint pour récupérer les produits
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#produit').empty().append('<option value="">Sélectionnez un produit</option>');
                            data.forEach(function (produit) {
                                // Ajout des données dans les options avec des attributs pour prix et quantité
                                $('#produit').append(
                                    `<option value="${produit.id}" data-prix="${produit.pu}" data-quantite="${produit.quantite}">
                                        ${produit.designation}
                                    </option>`
                                );
                            });
                        }
                    });
                }
                chargerProduits();

                // Événement pour détecter le changement de produit sélectionné
                $('#produit').on('change', function () {
                    const quantite = $('#produit option:selected').data('quantite'); // Récupérer la quantité disponible
                    if (quantite !== undefined) {
                        $('#quantite_produit').val(quantite); // Mettre à jour le champ de quantité disponible
                    } else {
                        $('#quantite_produit').val(''); // Réinitialiser si aucun produit n'est sélectionné
                    }
                });

                // Ajouter un produit au panier
                $('#ajouterProduit').click(function () {
                    const produitId = $('#produit').val();
                    const produitNom = $('#produit option:selected').text();
                    const produitPrix = parseFloat($('#produit option:selected').data('prix'));
                    const quantite = parseInt($('#quantite').val());

                    // Vérifier les valeurs
                    if (!produitId) {
                        alert('Veuillez sélectionner un produit.');
                        return;
                    }
                    if (isNaN(quantite) || quantite <= 0) {
                        alert('Veuillez renseigner une quantité valide.');
                        return;
                    }

                    // Vérifier si le produit existe déjà dans le panier
                    const produitExistant = panier.find(item => item.produitId === produitId);
                    if (produitExistant) {
                        // Incrémenter la quantité et recalculer le sous-total
                        produitExistant.quantite = quantite;
                        produitExistant.sousTotal = produitExistant.quantite * produitPrix;

                        // Mettre à jour la ligne correspondante dans le tableau
                        const row = $(`#panierTable tr[data-id="${produitId}"]`);
                        row.find('td:nth-child(3)').text(produitExistant.quantite); // Mettre à jour la quantité
                        row.find('td:nth-child(4)').text(produitExistant.sousTotal.toFixed(2) + " FCFA"); // Mettre à jour le sous-total
                    } else {
                        // Ajouter un nouveau produit au panier
                        const sousTotal = produitPrix * quantite;
                        panier.push({ produitId, produitNom, produitPrix, quantite, sousTotal });

                        // Ajouter au tableau
                        $('#panierTable tbody').append(`
                            <tr data-id="${produitId}">
                                <td>${produitNom}</td>
                                <td>${produitPrix.toFixed(2)} FCFA</td>
                                <td>${quantite}</td>
                                <td>${sousTotal.toFixed(2)} FCFA</td>
                                <td><button class="btn btn-danger btn-sm supprimer">Supprimer</button></td>
                            </tr>
                        `);
                    }

                    // Mettre à jour le total
                    total = panier.reduce((acc, item) => acc + item.sousTotal, 0);
                    $('#total').text(total.toFixed(2));

                    $('#quantite').val(''); // Réinitialiser la quantité
                });

                // Supprimer un produit du panier
                $('#panierTable').on('click', '.supprimer', function () {
                    const tr = $(this).closest('tr');
                    const produitId = tr.data('id');

                    // Mettre à jour le panier et recalculer le total
                    panier = panier.filter(item => item.produitId !== produitId);
                    total = panier.reduce((acc, item) => acc + item.sousTotal, 0);

                    // Supprimer la ligne correspondante
                    tr.remove();
                    $('#total').text(total.toFixed(2));
                });

                // Imprimer le reçu
                $('#imprimer').click(function () {
                    const venteData = { panier, total };

                    // Envoyer la vente au backend pour enregistrement et impression
                    $.ajax({
                        url: 'saveVente.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(venteData),
                        success: function (response) {
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
        </script> -->
        <script>
            $(document).ready(function () {
                let panier = [];
                let total = 0;

                // Charger les produits depuis la base de données (AJAX)
                function chargerProduits() {
                    $.ajax({
                        url: 'getProduits.php', // Endpoint pour récupérer les produits
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#produit').empty().append('<option value="">Sélectionnez un produit</option>');
                            data.forEach(function (produit) {
                                // Ajout des données dans les options avec des attributs pour prix et quantité
                                $('#produit').append(
                                    `<option value="${produit.id}" data-prix="${produit.pu}" data-quantite="${produit.quantite}">
                                        ${produit.designation}
                                    </option>`
                                );
                            });
                        }
                    });
                }
                chargerProduits();

                // Événement pour détecter le changement de produit sélectionné
                $('#produit').on('change', function () {
                    const quantite = $('#produit option:selected').data('quantite'); // Récupérer la quantité disponible
                    if (quantite !== undefined) {
                        $('#quantite_produit').val(quantite); // Mettre à jour le champ de quantité disponible
                    } else {
                        $('#quantite_produit').val(''); // Réinitialiser si aucun produit n'est sélectionné
                    }
                });

                // Vérifier si la quantité saisie dépasse la quantité disponible
                $('#quantite').on('input', function () {
                    const quantiteDispo = parseInt($('#quantite_produit').val());
                    const quantiteSaisie = parseInt($(this).val());

                    if (isNaN(quantiteSaisie) || quantiteSaisie <= 0) {
                        $(this).removeClass('is-valid').addClass('is-invalid');
                        $('#quantiteFeedback').text("Quantité invalide.");
                    } else if (quantiteSaisie > quantiteDispo) {
                        $(this).removeClass('is-valid').addClass('is-invalid');
                        $('#quantiteFeedback').text("Quantité saisie supérieure à la quantité disponible.");
                    } else {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                        $('#quantiteFeedback').text("");
                    }
                });

                // Ajouter un produit au panier
                $('#ajouterProduit').click(function () {
                    const produitId = $('#produit').val();
                    const produitNom = $('#produit option:selected').text();
                    const produitPrix = parseFloat($('#produit option:selected').data('prix'));
                    const quantiteDispo = parseInt($('#quantite_produit').val());
                    const quantite = parseInt($('#quantite').val());

                    // Vérifier les valeurs
                    if (!produitId) {
                        alert('Veuillez sélectionner un produit.');
                        return;
                    }
                    if (isNaN(quantite) || quantite <= 0) {
                        alert('Veuillez renseigner une quantité valide.');
                        return;
                    }
                    if (quantite > quantiteDispo) {
                        alert('La quantité saisie dépasse la quantité disponible.');
                        return;
                    }

                    // Vérifier si le produit existe déjà dans le panier
                    const produitExistant = panier.find(item => item.produitId === produitId);
                    if (produitExistant) {
                        // Incrémenter la quantité et recalculer le sous-total
                        produitExistant.quantite = quantite;
                        produitExistant.sousTotal = produitExistant.quantite * produitPrix;

                        // Mettre à jour la ligne correspondante dans le tableau
                        const row = $(`#panierTable tr[data-id="${produitId}"]`);
                        row.find('td:nth-child(3)').text(produitExistant.quantite); // Mettre à jour la quantité
                        row.find('td:nth-child(4)').text(produitExistant.sousTotal.toFixed(2) + " FCFA"); // Mettre à jour le sous-total
                    } else {
                        // Ajouter un nouveau produit au panier
                        const sousTotal = produitPrix * quantite;
                        panier.push({ produitId, produitNom, produitPrix, quantite, sousTotal });

                        // Ajouter au tableau
                        $('#panierTable tbody').append(`
                            <tr data-id="${produitId}">
                                <td>${produitNom}</td>
                                <td>${produitPrix.toFixed(2)} FCFA</td>
                                <td>${quantite}</td>
                                <td>${sousTotal.toFixed(2)} FCFA</td>
                                <td><button class="btn btn-danger btn-sm supprimer">Supprimer</button></td>
                            </tr>
                        `);
                    }

                    // Mettre à jour le total
                    total = panier.reduce((acc, item) => acc + item.sousTotal, 0);
                    $('#total').text(total.toFixed(2));

                    $('#quantite').val(''); // Réinitialiser la quantité
                });

                // Supprimer un produit du panier
                $('#panierTable').on('click', '.supprimer', function () {
                    const tr = $(this).closest('tr');
                    const produitId = tr.data('id');

                    // Mettre à jour le panier et recalculer le total
                    panier = panier.filter(item => item.produitId !== produitId);
                    total = panier.reduce((acc, item) => acc + item.sousTotal, 0);

                    // Supprimer la ligne correspondante
                    tr.remove();
                    $('#total').text(total.toFixed(2));
                });

                // Imprimer le reçu
                $('#imprimer').click(function () {
                    const venteData = { panier, total };

                    // Envoyer la vente au backend pour enregistrement et impression
                    $.ajax({
                        url: 'saveVente.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(venteData),
                        success: function (response) {
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