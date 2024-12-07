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
                        <div id="msg_print"></div>
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
                                    <button class="btn btn-success mt-2" id="ajouterProduit">Ajouter</button>
                                </div>
                            </div>
                            <!-- Panier -->
                            <div class="col-md-6">
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
                                    <div id="loading" style="display: none;">Traitement en cours...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        <!--JavaScript -->
        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery-3.6.0.min.js"></script>

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
                            produitNom: $(this).find('td:eq(0)').text(), // Récupérer le nom du produit à partir de la première colonne
                            produitPrix: parseFloat($(this).find('td:eq(1)').text()), // Prix unitaire
                            quantite: parseInt($(this).find('td:eq(2)').text()), // Quantité
                            sousTotal: parseFloat($(this).find('td:eq(3)').text()) // Sous-total
                        };
                        items.push(item);
                    });

                    // Vérifier s'il y a des articles ou un total à 0
                    if (items.length === 0 || total <= 0) {
                        alert('Aucune vente en cours');
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
                        },
                        error: function (xhr, status, error) {
                            console.error('Erreur AJAX:', error);
                            alert('Erreur lors de l\'enregistrement du reçu.');
                        },
                        complete: function () { // Cacher l'indicateur de chargement et réactiver le bouton après la requête
                            $('#loading').hide();
                            $('#imprimer').prop('disabled', false);
                        }
                    });
                });

                function print() {
                    // Créer un nouveau document d'impression
                    var printWindow = window.open('', '', 'width=800, height=600');

                    // Récupérer le contenu du tableau de la facture
                    var tableContent = $('#panierTable').html();
                    var total = $('#total').text();
                    var remise = $('#remise').val();
                    var venteId = $('#venteId').text();

                    // Contenu HTML pour la page d'impression
                    var printContent = `
                        <html>
                        <head>
                            <title>Facture N° ${venteId}</title>
                            <style>
                                body { font-family: Arial, sans-serif; padding: 20px; }
                                h1, h3 { text-align: center; }
                                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                table, th, td { border: 1px solid #000; }
                                th, td { padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; }
                                .total { text-align: right; margin-top: 20px; font-weight: bold; }
                            </style>
                        </head>
                        <body>
                            <h1>Facture N° ${venteId}</h1>
                            <h3>Date : ${new Date().toLocaleDateString()}</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix Unitaire</th>
                                        <th>Quantité</th>
                                        <th>Sous-total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableContent}
                                </tbody>
                            </table>
                            <div class="total">
                                <p>Remise: ${remise}%</p>
                                <p>Total : ${total} FCFA</p>
                            </div>
                        </body>
                        </html>
                    `;

                    // Charger le contenu dans la fenêtre d'impression
                    printWindow.document.open();
                    printWindow.document.write(printContent);
                    printWindow.document.close();

                    // Lancer l'impression
                    printWindow.print();

                    // Fermer la fenêtre après l'impression
                    printWindow.close();
                }

                // Fonction pour réinitialiser le contenu du tableau après impression
                function clearTableBody() {
                    $('#panierTable tbody').empty(); // Vider le contenu du tableau

                    // Réinitialiser les valeurs du total et de la remise
                    $('#total').text('0.00'); $('#remise').val('');
                    $('#venteId').text(''); // Optionnel: Réinitialiser l'ID de la facture

                    // Réinitialiser le champ de quantité (si nécessaire)
                    $('#quantite').val(''); $('#quantite_produit').val('');
                }

                // Charger l'ID de la dernière vente
                function chargerDernierIdVente() {
                    $.ajax({
                        url: 'getLastVenteId.php', // Endpoint pour récupérer le dernier ID de vente
                        method: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            $('#venteId').text(response.lastId); // Afficher le prochain ID
                        },
                        error: function () {
                            console.error('Impossible de charger le dernier ID de vente.');
                        }
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

                    $('#quantite').val('');
                });

                // Supprimer un produit du panier
                $('#panierTable').on('click', '.supprimer', function () {
                    const tr = $(this).closest('tr');
                    const produitId = tr.data('id');

                    panier = panier.filter(item => item.produitId !== produitId);
                    total = panier.reduce((acc, item) => acc + item.sousTotal, 0);

                    tr.remove();
                    $('#total').text(total.toFixed(2));
                });
            });
        </script>
    </body>
</html>