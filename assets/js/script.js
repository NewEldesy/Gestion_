///////////////////////////////////////////////////////////////// Start Total Montant ////////////////////////////////////////////////////////////////////////////////////////
// Fonction pour afficher totals des ventes
function updateTransactionTotals() {
    $.ajax({
        url: 'get_totals.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#t_total').text(Number(data.total).toFixed(2)); $('#t_today').text(Number(data.today).toFixed(2));
            $('#t_week').text(Number(data.week).toFixed(2)); $('#t_month').text(Number(data.month).toFixed(2));
            $('#t_year').text(Number(data.year).toFixed(2));
        },
        error: function(xhr, status, error) {
            console.error('Erreur Ajax:', status, error);
        }
    });
}
updateTransactionTotals();
// Fonction pour afficher le montant totals des prestations
function updatePrestationTotals() {
    $.ajax({
        url: 'get_totalPs.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data && data.today !== undefined && data.week !== undefined && data.month !== undefined && data.year !== undefined) {
                $('#p_total').text(Number(data.total).toFixed(2)); $('#p_today').text(Number(data.today).toFixed(2));
                $('#p_week').text(Number(data.week).toFixed(2)); $('#p_month').text(Number(data.month).toFixed(2));
                $('#p_year').text(Number(data.year).toFixed(2));
            } else {
                console.error('Données invalides reçues:', data);
            }
        },        
        error: function(xhr, status, error) {
            console.error('Erreur Ajax:', status, error);
            alert('Impossible de récupérer les données. Veuillez réessayer plus tard.');
        }        
    });
}
updatePrestationTotals();
///////////////////////////////////////////////////////////////// End Total Montant /////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// Start Prestataire /////////////////////////////////////////////////////////////////////////////////////////
// Add Prestation
$(document).on('click', '#btn_add_prestation', function(e){
    e.preventDefault();
    var nom = $("#nom").val(); var prenom = $("#prenom").val(); var date_naissance = $("#date_naissance").val();
    var telephone = $("#telephone").val(); var telephone2 = $("#telephone2").val(); var poste = $("#poste").val();
    if (nom.trim() !== "" && prenom.trim() !== "" && date_naissance.trim() !== "" && telephone.trim() !== "" && poste.trim() !== "") {
        $.ajax({
            url: "prestataire_add.php",
            type: "POST",
            data: {nom: nom, prenom: prenom, date_naissance: date_naissance, telephone:telephone,
                telephone2:telephone2,
                poste:poste
            },
            success: function(data){
                $("#result_prestation").html(data).delay(700).slideDown(700);
                affPrestataires();
                $("#result_prestation").delay(2000).slideUp(700);
            },
            error: function(){$("#result_prestation").html('<div class="alert alert-danger">Erreur lors de l\'ajout du prestataire.</div>');}
        });
        $('#exampleModalAdd').modal('hide');
    } else {$("#result_prestation").html('<div class="alert alert-warning">Les champs ne peuvent pas être vide.</div>');}
});
// Aff Prestataire
function affPrestataires(){
    $.ajax({
        url: "prestataire_read.php",
        type: "post",
        success: function(data) {
            $("#affPrest").html(data).delay(500).slideDown(500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erreur lors de la récupération des catégories :', textStatus, errorThrown);
            $("#affPrest").html('<div class="alert alert-danger">Erreur lors du chargement des catégories.</div>');
        }
    });
}
affPrestataires();
//Supprimer Prestataire
$(document).on('click', '.btn_del_prestataire', function(e){
    e.preventDefault();
    if (window.confirm("Voulez-vous supprimer ce Prestataire?")) {
        var id = $(this).data("id");

        $.ajax({
            url: "prestataire_delete.php",
            type: "post",
            data: { id: id },
            success: function(data) {
                $("#result_prestation").html(data).delay(700).slideDown(700);
                affPrestataires();
                $("#result_prestation").delay(2000).slideUp(700);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erreur lors de la suppression :', textStatus, errorThrown);
                $("#result_prestation").html('<div class="alert alert-danger">Erreur lors de la suppression du prestataire.</div>').delay(2000).slideUp(700);
            }
        });
    } else {return false;}
});
//Fonction pour modifier le prestataire
function updatePrestataire()
{
    $(document).on("click" , "#btn_up_prestataire" , function(e)
    {
        e.preventDefault(); var id = $(this).attr("value");
        $.ajax({
            url:"prestataire_mod.php",
            type:"post",
            data:{
                id:id
            },
            success: function(data){
                $("#prestataire_mod").html(data);
            }
        });
    });
}
updatePrestataire();
//fonction de mise a jour categorie
$(document).ready(function () {
    // Capture le clic sur le bouton de mise à jour
    $(document).on("click", "#btn_maj_prestation", function (e) {
        e.preventDefault(); // Empêche le comportement par défaut
        // Récupère les données du formulaire
        var id = $("#pres_id").val(); var nom = $("#pres_nom").val();
        var prenom = $("#pres_prenom").val(); var date_naissance = $("#pres_date_naissance").val();
        var telephone = $("#pres_telephone").val(); var telephone2 = $("#pres_telephone2").val(); var poste = $("#pres_poste").val();
        // Envoie les données via AJAX
        $.ajax({
            url: "prestataire_update.php", // Le script côté serveur qui gère la mise à jour
            type: "POST",
            data: {id: id, nom: nom, prenom: prenom, date_naissance: date_naissance,
                telephone: telephone, telephone2: telephone2, poste: poste,
            },
            success: function (data) {
                $("#result_prestation").html(data).delay(700).slideDown(700);
                affPrestataires();
                $("#result_prestation").delay(2000).slideUp(700);
                $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_prestation").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(2000).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Prestataire //////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// Start Produit ///////////////////////////////////////////////////////////////////////////////////////////
// Add Produit
$(document).on('click', '#btn_add_produit', function(e){
    e.preventDefault();
    var designation = $("#designation").val(); var vehicule = $("#vehicule").val(); var pu = $("#pu").val(); var description = $("#description").val();
    if (designation.trim() !== "" && designation.trim() !== "" && vehicule.trim() !== "" && pu.trim() !== "") {
        $.ajax({
            url: "produits_add.php",
            type: "POST",
            data: {designation: designation, vehicule: vehicule, pu: pu,description:description},
            success: function(data){
                $("#result_produit").html(data).delay(700).slideDown(700);
                affProduits();
                $("#result_produit").delay(2000).slideUp(700);
            },
            error: function(){$("#result_produit").html('<div class="alert alert-danger">Erreur lors de l\'ajout du prestataire.</div>');}
        });
        $('#exampleModalAdd').modal('hide');
    } else {$("#result_produit").html('<div class="alert alert-warning">Les champs ne peuvent pas être vide.</div>');}
});
// Aff Produit
function affProduits(){
    $.ajax({
        url: "produits_read.php",
        type: "post",
        success: function(data) {
            $("#aff_produit").html(data).delay(500).slideDown(500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erreur lors de la récupération des produits :', textStatus, errorThrown);
            $("#aff_produit").html('<div class="alert alert-danger">Erreur lors du chargement des produits.</div>');
        }
    });
}
affProduits();
//Supprimer Produit
$(document).on('click', '.btn_del_produit', function(e){
    e.preventDefault();
    if (window.confirm("Voulez-vous supprimer ce Produit?")) {
        var id = $(this).data("id");

        $.ajax({
            url: "produits_delete.php",
            type: "post",
            data: { id: id },
            success: function(data) {
                $("#result_produit").html(data).delay(700).slideDown(700);
                affProduits();
                $("#result_produit").delay(2000).slideUp(700);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erreur lors de la suppression :', textStatus, errorThrown);
                $("#result_produit").html('<div class="alert alert-danger">Erreur lors de la suppression du prestataire.</div>').delay(2000).slideUp(700);
            }
        });
    } else {return false;}
});
//Fonction pour modifier le Produit
function updateProduit()
{
    $(document).on("click" , "#btn_up_produit" , function(e)
    {
        e.preventDefault(); var id = $(this).attr("value");
        $.ajax({
            url:"produits_mod.php",
            type:"post",
            data:{
                id:id
            },
            success: function(data){
                $("#produit_mod").html(data);
            }
        });
    });
}
updateProduit();
//fonction de mise a jour du Produit
$(document).ready(function () {
    // Capture le clic sur le bouton de mise à jour
    $(document).on("click", "#btn_maj_produit", function (e) {
        e.preventDefault(); // Empêche le comportement par défaut
        var id = $("#produit_id").val(); var designation = $("#produit_designation").val(); // Récupère les données du formulaire
        var vehicule = $("#produit_vehicule").val(); var pu = $("#produit_prixunitaire").val();
        var description = $("#produit_description").val();
        $.ajax({ // Envoie les données via AJAX
            url: "produits_update.php", // Le script côté serveur qui gère la mise à jour
            type: "POST",
            data: {id: id, designation: designation, vehicule: vehicule, pu: pu, description: description,
            },
            success: function (data) {
                $("#result_produit").html(data).delay(700).slideDown(700);
                affProduits();
                $("#result_produit").delay(2000).slideUp(700);
                $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_produit").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(2000).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Produit /////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////// Start Stock ///////////////////////////////////////////////////////////////////////////////////////////
// Aff Stock
function affStocks(){
    $.ajax({
        url: "stock_read.php",
        type: "post",
        success: function(data) {
            $("#affStock").html(data).delay(500).slideDown(500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erreur lors de la récupération du stock des produits :', textStatus, errorThrown);
            $("#affStock").html('<div class="alert alert-danger">Erreur lors du chargement des produits en stock.</div>');
        }
    });
}
affStocks();
//Fonction pour modifier le Stock
function updateStock()
{
    $(document).on("click" , "#btn_up_stock" , function(e)
    {
        e.preventDefault(); var id = $(this).attr("value");
        $.ajax({
            url:"stock_mod.php",
            type:"post",
            data:{
                id:id
            },
            success: function(data){
                $("#stock_mod").html(data);
            }
        });
    });
}
updateStock();
//fonction de mise a jour Stock
$(document).ready(function () {
    // Capture le clic sur le bouton de mise à jour
    $(document).on("click", "#btn_maj_stock", function (e) {
        e.preventDefault(); // Empêche le comportement par défaut
        var id = $("#stock_id").val(); var id_produit = $("#stock_produit").val(); var quantite = $("#stock_quantite").val();
        $.ajax({ // Envoie les données via AJAX
            url: "stock_update.php", // Le script côté serveur qui gère la mise à jour
            type: "POST",
            data: {id: id, id_produit: id_produit, quantite: quantite,},
            success: function (data) {
                $("#result_stock").html(data).delay(700).slideDown(700);
                affStocks();
                $("#result_stock").delay(2000).slideUp(700);
                $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_stock").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(2000).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Stock /////////////////////////////////////////////////////////////////////////////////////////////