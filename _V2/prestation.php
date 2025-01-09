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
                        <input type="number" id="prix_prestation" class="form-control" placeholder="Prix de la Prestation" readonly>
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
                        <input type="button" class="btn btn-primary" id="prestation_" value="Imprimer Facture">
                        <div id="loading" style="display: none;">...</div>
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

                $('#prestation_').on('click', function () {
                    // Montrer l'indicateur de chargement
                    $('#loading').show();
                    $('#prestation_').prop('disabled', true);

                    // Récupérer les informations de la facture
                    var venteId = $('#venteId').text();
                    var total = parseFloat($('#total').text());
                    var remise = parseFloat($('#remise').val()) || 0; // Par défaut, aucune remise si non spécifié
                    var prestataire = $('#prestataire').val(); // Récupérer l'ID ou le nom du prestataire
                    var statuts = 'payé';
                    var items = [];

                    // Vérifier si un prestataire est sélectionné
                    if (!prestataire) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Veuillez sélectionner un prestataire.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        $('#loading').hide();
                        $('#prestation_').prop('disabled', false);
                        return; // Arrêter l'exécution
                    }

                    // Récupérer les articles du tableau
                    $('#panierTable tbody tr').each(function () {
                        var item = {
                            produitId: $(this).data('id'), // Récupérer l'ID du produit stocké dans l'attribut `data-id`
                            produitNom: $(this).find('td:eq(0)').text(), // Récupérer le nom du produit à partir de la première colonne
                            produitPrix: parseFloat($(this).find('td:eq(1)').text()), // Prix unitaire
                            quantite: parseInt($(this).find('td:eq(2)').text()), // Quantité
                            sousTotal: parseFloat($(this).find('td:eq(3)').text()) // Sous-total
                        };
                        items.push(item);
                    });

                    // Vérifier s'il y a des articles ou un total à 0
                    if (items.length === 0 || total <= 0) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Aucune vente en cours</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        $('#loading').hide();
                        $('#prestation_').prop('disabled', false);
                        return; // Arrêter l'exécution
                    }

                    // Envoyer la requête AJAX pour enregistrer la transaction
                    $.ajax({
                        url: 'save_prestation.php',
                        method: 'POST',
                        data: {
                            venteId: venteId,
                            total: total,
                            remise: remise,
                            prestataire: prestataire, // Ajouter le prestataire
                            statuts: statuts,
                            items: JSON.stringify(items) // Sérialiser les articles sous forme JSON
                        },
                        success: function (response) {
                            // Afficher un message de confirmation
                            $("#msg_print").html(response).delay(700).slideDown(700).delay(2000).slideUp(700);
                            setTimeout(function () { // Imprimer et réinitialiser l'interface après un court délai
                                print(); chargerPrestations(); chargerPrestataires(); chargerDernierIdPrestation(); clearTableBody();
                            }, 100);
                            $("#result_vente").html('<div class="alert alert-success text-center">Facture Emise.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        },
                        error: function (xhr, status, error) {
                            console.error('Erreur AJAX:', error);
                            $("#result_vente").html('<div class="alert alert-danger text-center">Erreur lors de l\'enregistrement de la facture.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        },
                        complete: function () { // Cacher l'indicateur de chargement et réactiver le bouton après la requête
                            $('#loading').hide();
                            $('#prestation_').prop('disabled', false);
                        }
                    });
                });

                // Impression
                function print() {
                    $('#loading').show();
                    $('#prestation_').prop('disabled', true);

                    var venteId = $('#venteId').text(); // Assurez-vous que cet élément contient l'ID de la vente

                    if (!venteId) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Aucune vente sélectionnée.</div>')
                            .delay(700).slideDown(700).delay(2100).slideUp(700);
                        $('#loading').hide();
                        $('#prestation_').prop('disabled', false);
                        return;
                    }

                    // Redirection vers la page facture avec l'ID comme paramètre GET
                    window.location.href = `fprestataire.php?id=${venteId}`;
                }

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

                // Mettre à jour le champ #prix_prestation quand un produit est sélectionné
                $('#prestation').on('change', function () {
                    const prix = $(this).find('option:selected').data('prix');
                    $('#prix_prestation').val(prix.toFixed(2));
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

                    recalculerTotal();
                });

                // Fonction pour recalculer le total avec la remise
                function recalculerTotal() {
                    let sousTotal = 0;
                    panier.forEach(item => {
                        sousTotal += item.sousTotal;
                    });
                    let remise = parseFloat($('#remise').val()) || 0; // Par défaut, aucune remise si non spécifiée
                    let totalAvecRemise = sousTotal - (sousTotal * (remise / 100));
                    total = totalAvecRemise.toFixed(2);
                    $('#total').text(total); // Met à jour l'affichage du total
                }

                // Supprimer un produit du panier
                $('#panierTable').on('click', '.supprimer', function () {
                    const produitId = $(this).closest('tr').data('id');
                    panier = panier.filter(item => item.produitId !== produitId); // Supprimer du panier
                    $(this).closest('tr').remove(); // Supprimer la ligne du tableau
                    recalculerTotal(); // Recalculer le total
                });

                // Recalculer le total lorsqu'une remise est saisie
                $('#remise').on('input', function () {
                    recalculerTotal();
                });

                // Charger l'ID de la dernière vente
                function chargerDernierIdPrestation() {
                    $.ajax({
                        url: 'getLastPrestationId.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function (response) { $('#venteId').text(response.lastId); },
                        error: function () { console.error('Impossible de charger le dernier numéro de facture.'); }
                    });
                }
                chargerDernierIdPrestation();

                // Fonction pour réinitialiser le contenu du tableau après impression
                function clearTableBody() {
                    $('#panierTable tbody').empty();
                    $('#total').text('0.00'); $('#remise').val('');
                    $('#venteId').text(''); $('#prix_prestation').val('');
                }
            });
        </script>
    </body>
</html>