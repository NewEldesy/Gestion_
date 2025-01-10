<?php include_once('header.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2>Interface de Vente</h2>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div id="result_vente"  class="mt-2 fw-bolder"></div>
                    <h4 class="mt-2">Produits</h4>
                    <div class="mt-2">
                        <select id="produit" class="form-select">
                            <option value="">Sélectionnez un produit</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <input type="number" id="quantite_produit" class="form-control" placeholder="Quantité disponible du produit" readonly>
                    </div>
                    <div id="quantiteFeedback" class="invalid-feedback"></div>
                    <div class="mt-2">
                        <input type="number" id="quantite" class="form-control" placeholder="Quantité" min="1">
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
                    <h5>Total : <span id="total">0.00</span> FCFA</h5>
                    <div class="col d-flex justify-content-center">
                        <input type="button" class="btn btn-primary" id="imprimer" value="Imprimer Facture">
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

                $('#imprimer').on('click', function () {
                    // Montrer l'indicateur de chargement
                    $('#loading').show();
                    $('#imprimer').prop('disabled', true);

                    // Récupérer les informations de la facture
                    var venteId = $('#venteId').text();
                    var total = parseFloat($('#total').text());
                    var remise = parseFloat($('#remise').val()) || 0; // Par défaut, aucune remise si non spécifié
                    var statuts = 'payé';
                    var items = [];

                    // Récupérer les articles du tableau
                    $('#panierTable tbody tr').each(function () {
                        var item = {
                            produitId: $(this).data('id'), // Récupérer l'ID du produit stocké dans l'attribut `data-id`
                            produitNom: $(this).find('td:eq(0)').text().trim(), // Récupérer le nom du produit à partir de la première colonne
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
                        $('#imprimer').prop('disabled', false);
                        return; // Arrêter l'exécution
                    }

                    // Envoyer la requête AJAX pour enregistrer la transaction
                    $.ajax({
                        url: 'save_vente.php',
                        method: 'POST',
                        data: {
                            venteId: venteId,
                            total: total,
                            remise: remise,
                            statuts: statuts,
                            items: JSON.stringify(items)
                        },
                        success: function (response) {
                            // Afficher un message de confirmation
                            $("#msg_print").html(response).delay(700).slideDown(700);
                            $("#msg_print").delay(2000).slideUp(700);
                            setTimeout(function () { // Imprimer et réinitialiser l'interface après un court délai
                                print(); chargerProduits(); chargerDernierIdVente(); clearTableBody();
                            }, 100);
                            $("#result_vente").html('<div class="alert alert-success text-center">Facture Emise.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        },
                        error: function (xhr, status, error) {
                            console.error('Erreur AJAX:', error);
                            $("#result_vente").html('<div class="alert alert-danger text-center">Erreur lors de l\'enregistrement de la facture.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        },
                        complete: function () { // Cacher l'indicateur de chargement et réactiver le bouton après la requête
                            $('#loading').hide();
                            $('#imprimer').prop('disabled', false);
                        }
                    });
                });

                function print() {
                    $('#loading').show();
                    $('#imprimer').prop('disabled', true);

                    var venteId = $('#venteId').text(); // Assurez-vous que cet élément contient l'ID de la vente

                    if (!venteId) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Aucune vente sélectionnée.</div>')
                            .delay(700).slideDown(700).delay(2100).slideUp(700);
                        $('#loading').hide();
                        $('#imprimer').prop('disabled', false);
                        return;
                    }

                    // Redirection vers la page facture avec l'ID comme paramètre GET
                    window.location.href = `facture.php?id=${venteId}`;
                }

                // Fonction pour réinitialiser le contenu du tableau après impression
                function clearTableBody() {
                    $('#panierTable tbody').empty();
                    $('#total').text('0.00'); $('#remise').val('');
                    $('#venteId').text('');
                    $('#quantite').val(''); $('#quantite_produit').val('');
                }

                // Charger l'ID de la dernière vente
                function chargerDernierIdVente() {
                    $.ajax({
                        url: 'getLastVenteId.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function (response) { $('#venteId').text(response.lastId); },
                        error: function () { console.error('Impossible de charger le dernier ID de vente.'); }
                    });
                }
                chargerDernierIdVente();

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
                    const quantite = $('#produit option:selected').data('quantite');
                    if (quantite !== undefined) { $('#quantite_produit').val(quantite); }
                    else { $('#quantite_produit').val(''); }
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
                        $('#quantiteFeedback').text("");}
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

                // Ajouter un produit au panier
                $('#ajouterProduit').click(function () {
                    const produitId = $('#produit').val();
                    const produitNom = $('#produit option:selected').text();
                    const produitPrix = parseFloat($('#produit option:selected').data('prix'));
                    const quantiteDispo = parseInt($('#quantite_produit').val());
                    const quantite = parseInt($('#quantite').val());

                    if (!produitId) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Veuillez sélectionner un produit.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        return;
                    }
                    if (isNaN(quantite) || quantite <= 0) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">Veuillez renseigner une quantité valide.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                        return;
                    }
                    if (quantite > quantiteDispo) {
                        $("#result_vente").html('<div class="alert alert-danger text-center">La quantité saisie dépasse la quantité disponible.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
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
                            </tr>`);
                    }

                    recalculerTotal();
                });

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
            });
        </script>
    </body>
</html>