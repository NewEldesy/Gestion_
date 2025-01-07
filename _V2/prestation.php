<?php include_once('header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2>Interface des Prestations</h2>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div id="result_vente"  class="mt-2 fw-bolder"></div>
                    <h4 class="mt-2">Prestations</h4>
                    <div class="mt-2">
                        <select id="prestation" class="form-select">
                            <option value="">Sélectionnez une prestation</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <input type="number" id="prix_prestaion" class="form-control" placeholder="Prix de la Prestation" readonly>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-success mt-2" id="ajouterProduit">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4>Facture N° : <span id="venteId"></span></h4>
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
                        <tbody></tbody>
                    </table>
                    <div class="mb-3">
                        <label for="remise" class="form-label">Remise (en %)</label>
                        <input type="number" class="form-control" id="remise" min="5" placeholder="Exemple : 5 ou 10%">
                    </div>
                    <div class="mb-3">
                        <label for="prestataire" class="form-label">Sélectionnez le Prestataire</label>
                        <select id="prestataire" class="form-select">
                            <option value="">Sélectionnez un prestataire</option>
                        </select>
                    </div>
                    <h5>Total : <span id="total">0.00</span> FCFA</h5>
                    <div class="col d-flex justify-content-center">
                        <input type="button" class="btn btn-primary" id="imprimer" value="Imprimer Facture">
                        <div id="loading" style="display: none;">Traitement en cours...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!--JavaScript -->
        <?php include_once('footer.php'); ?>

        <script>
            $(document).ready(function () {
                let panier = [];
                let total = 0;

                // Charger les prestations depuis la base de données (AJAX)
                function chargerPrestations() {
                    // Afficher un message de chargement dans la liste déroulante
                    $('#prestation').empty().append('<option value="">Chargement des prestations...</option>');

                    $.ajax({
                        url: 'getPrestations.php', // Endpoint pour récupérer les prestations
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Vider la liste et ajouter l'option par défaut
                            $('#prestation').empty().append('<option value="">Sélectionnez une prestation</option>');
                            
                            // Ajouter chaque prestation à la liste déroulante
                            data.forEach(function (prestation) {
                                $('#prestation').append(
                                    `<option value="${prestation.id}" data-prix="${prestation.prix}" data-description="${prestation.description}">
                                        ${prestation.designation}
                                    </option>`
                                );
                            });
                        },
                        error: function (xhr, status, error) {
                            // Gérer les erreurs lors de la requête AJAX
                            console.error("Erreur lors du chargement des prestations :", error);
                            $('#prestation').empty().append('<option value="">Erreur de chargement des prestations</option>');
                        }
                    });
                }

                // Charger les prestataires depuis la base de données (AJAX)
                function chargerPrestataires() {
                    // Ajouter un message de chargement dans la liste déroulante
                    $('#prestataire').empty().append('<option value="">Chargement des prestataires...</option>');

                    $.ajax({
                        url: 'getPrestataires.php', // Endpoint pour récupérer les prestataires
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Vérifiez si les données existent et sont valides
                            if (Array.isArray(data) && data.length > 0) {
                                // Vider la liste déroulante et ajouter une option par défaut
                                $('#prestataire').empty().append('<option value="">Sélectionnez un prestataire</option>');

                                // Ajouter chaque prestataire à la liste déroulante
                                data.forEach(function (prestataire) {
                                    $('#prestataire').append(
                                        `<option value="${prestataire.id}">${prestataire.nom} ${prestataire.prenom}</option>`
                                    );
                                });
                            } else {
                                // Si aucune donnée, afficher un message approprié
                                $('#prestataire').empty().append('<option value="">Aucun prestataire trouvé</option>');
                            }
                        },
                        error: function (xhr, status, error) {
                            // Gérer les erreurs lors de la requête AJAX
                            console.error("Erreur lors du chargement des prestataires :", error);
                            $('#prestataire').empty().append('<option value="">Erreur lors du chargement des prestataires</option>');
                        }
                    });
                }
                chargerPrestations();
                chargerPrestataires();

                // Mettre à jour le champ #prix_prestaion quand un produit est sélectionné
                $('#prestation').on('change', function () {
                    const prix = $(this).find('option:selected').data('prix');
                    $('#prix_prestaion').val(prix.toFixed(2));
                });

                // Ajouter un produit au panier
                $('#ajouterProduit').click(function () {
                    const produitId = $('#prestation').val();
                    const produitNom = $('#prestation option:selected').text();
                    const produitPrix = parseFloat($('#prestation option:selected').data('prix'));
                    const quantite = 1;

                    if (!produitId) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Veuillez sélectionner un produit.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        return;
                    }

                    const produitExistant = panier.find(item => item.produitId === produitId);
                    if (produitExistant) {
                        produitExistant.quantite = quantite;
                        produitExistant.sousTotal = produitExistant.quantite * produitPrix;

                        const row = $(`#panierTable tr[data-id="${produitId}"]`);
                        row.find('td:nth-child(3)').text(produitExistant.quantite);
                        row.find('td:nth-child(4)').text(produitExistant.sousTotal.toFixed(2) + " FCFA");
                    } else {
                        const sousTotal = produitPrix * quantite;
                        panier.push({ produitId, produitNom, produitPrix, quantite, sousTotal });

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

                    total = panier.reduce((acc, item) => acc + item.sousTotal, 0);
                    $('#total').text(total.toFixed(2));
                });

                // Supprimer un produit du panier
                $('#panierTable').on('click', '.supprimer', function () {
                    const tr = $(this).closest('tr'); // Sélectionner la ligne associée
                    const sousTotal = parseFloat(tr.find('td:nth-child(4)').text()); // Récupérer le sous-total de la ligne
                    total -= sousTotal; // Soustraire le sous-total du produit du total
                    $('#total').text(total.toFixed(2)); // Mettre à jour le total affiché
                    tr.remove(); // Supprimer la ligne du tableau
                });
            });
        </script>
    </body>
</html>