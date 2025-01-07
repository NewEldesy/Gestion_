///////////////////////////////////////////////////////////////// Start Login /////////////////////////////////////////////////////////////////////////////////////////////////
$(document).on('click', '#login', function(e) {
    e.preventDefault();
    var Email1 = $("#Email1").val();
    var Password1 = $("#Password1").val();
    if (Email1.trim() !== "" && Password1.trim() !== "") {
        $.ajax({
            url: "login.php",
            type: "POST",
            data: { Email1: Email1, Password1: Password1 },
            dataType: "json",
            success: function(data){
                $("#login_result").html('<div class="alert alert-'+(data.status=== 'success' ? 'success' : 'danger')+'text-center">'+data.message+'</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
                // Vérifie si la connexion est réussie avant de rediriger
                if (data.status === 'success') {
                    setTimeout(function() { window.location.href = "dashboard.php"; }, 1400);
                }
            },
            error: function() {
                $("#login_result").html('<div class="alert alert-danger text-center">Erreur lors de la connexion.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            }
        });
    } else {
        $("#login_result").html('<div class="alert alert-warning text-center">Les champs ne peuvent pas être vides.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
    }
});
///////////////////////////////////////////////////////////////// End Login //////////////////////////////////////////////////////////////////////////////////////////////////
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
        }     
    });
}
updatePrestationTotals();
///////////////////////////////////////////////////////////////// End Total Montant /////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// Start Prestataire /////////////////////////////////////////////////////////////////////////////////////////
// Add Prestation
$(document).on('click', '#btn_add_prestataire', function(e){
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
                $("#result_prestataire").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affPrestataires(); $("#exampleModalAdd").modal("hide");
            },
            error: function(){$("#result_prestataire").html('<div class="alert alert-danger">Erreur lors de l\'ajout du prestataire.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
        });
        $('#exampleModalAdd').modal('hide');
    } else {$("#result_prestataire").html('<div class="alert alert-warning">Les champs ne peuvent pas être vide.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
});
// Aff Prestataire
function affPrestataires(){
    $.ajax({
        url: "prestataire_read.php",
        type: "post",
        success: function(data) {
            $("#affPrest").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
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
                $("#result_prestataire").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affPrestataires();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erreur lors de la suppression :', textStatus, errorThrown);
                $("#result_prestataire").html('<div class="alert alert-danger">Erreur lors de la suppression du prestataire.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
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
//fonction de mise a jour Prestataire
$(document).ready(function () {
    // Capture le clic sur le bouton de mise à jour
    $(document).on("click", "#btn_maj_prestataire", function (e) {
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
                telephone: telephone, telephone2: telephone2, poste: poste
            },
            success: function (data) {
                $("#result_prestataire").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affPrestataires(); $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_prestataire").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Prestataire //////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// Start Produit ///////////////////////////////////////////////////////////////////////////////////////////
// Add Produit
$(document).on('click', '#btn_add_produit', function(e){
    e.preventDefault();
    var designation = $("#designation").val(); var pu = $("#pu").val(); var description = $("#description").val();
    if (designation.trim() !== "" && designation.trim() !== "" && pu.trim() !== "") {
        $.ajax({
            url: "produits_add.php",
            type: "POST",
            data: {designation: designation, pu: pu,description:description},
            success: function(data){
                $("#result_produit").html(data).delay(500).slideDown(700).delay(2100).slideUp(700);
                affProduits();
            },
            error: function(){$("#result_produit").html('<div class="alert alert-danger">Erreur lors de l\'ajout du prestataire.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
        });
        $('#exampleModalAdd').modal('hide');
    } else {$("#result_produit").html('<div class="alert alert-warning">Les champs ne peuvent pas être vide.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
});
// Aff Produit
function affProduits(){
    $.ajax({
        url: "produits_read.php",
        type: "post",
        success: function(data) {
            $("#aff_produit").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
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
                $("#result_produit").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affProduits();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#result_produit").html('<div class="alert alert-danger">Erreur lors de la suppression du prestataire.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
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
        var pu = $("#produit_prixunitaire").val(); var description = $("#produit_description").val();
        $.ajax({ // Envoie les données via AJAX
            url: "produits_update.php", // Le script côté serveur qui gère la mise à jour
            type: "POST",
            data: {id: id, designation: designation, pu: pu, description: description,
            },
            success: function (data) {
                $("#result_produit").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affProduits(); $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_produit").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Produit /////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// Start Prestation ///////////////////////////////////////////////////////////////////////////////////////////
// Add Prestation
$(document).on('click', '#btn_add_prestation', function(e){
    e.preventDefault();
    var designation = $("#designation").val(); var prix = $("#prix").val(); var description = $("#description").val();
    if (designation.trim() !== "" && prix.trim() !== "" && description.trim() !== "") {
        $.ajax({
            url: "prestations_add.php",
            type: "POST",
            data: {designation: designation, prix: prix, description: description},
            success: function(data){
                $("#result_prestation").html(data).delay(500).slideDown(700).delay(2100).slideUp(700);
                affPrestations();
            },
            error: function(){$("#result_prestation").html('<div class="alert alert-danger">Erreur lors de l\'ajout de la prestation.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
        });
        $('#exampleModalAdd').modal('hide');
    } else {$("#result_prestation").html('<div class="alert alert-warning">Les champs ne peuvent pas être vide.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
});
// Aff Prestation
function affPrestations(){
    $.ajax({
        url: "prestations_read.php",
        type: "post",
        success: function(data) {
            $("#aff_prestation").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erreur lors de la récupération des prestations :', textStatus, errorThrown);
            $("#aff_prestation").html('<div class="alert alert-danger">Erreur lors du chargement des prestations.</div>');
        }
    });
}
affPrestations();
//Supprimer Prestation
$(document).on('click', '.btn_del_prestation', function(e){
    e.preventDefault();
    if (window.confirm("Voulez-vous supprimer ce Prestation ?")) {
        var id = $(this).data("id");

        $.ajax({
            url: "prestations_delete.php",
            type: "post",
            data: { id: id },
            success: function(data) {
                $("#result_prestation").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affPrestations();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#result_prestation").html('<div class="alert alert-danger">Erreur lors de la suppression du prestation.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            }
        });
    } else {return false;}
});
//Fonction pour modifier le Prestation
function updatePrestation()
{
    $(document).on("click" , "#btn_up_prestation" , function(e)
    {
        e.preventDefault(); var id = $(this).attr("value");
        $.ajax({
            url:"prestations_mod.php",
            type:"post",
            data:{
                id:id
            },
            success: function(data){
                $("#prestation_mod").html(data);
            }
        });
    });
}
updatePrestation();
//fonction de mise a jour du Produit
$(document).ready(function () {
    // Capture le clic sur le bouton de mise à jour
    $(document).on("click", "#btn_maj_prestation", function (e) {
        e.preventDefault(); // Empêche le comportement par défaut
        var id = $("#prestation_id").val(); var designation = $("#prestation_designation").val(); // Récupère les données du formulaire
        var prix = $("#prestation_prix").val(); var description = $("#prestation_description").val();
        $.ajax({ // Envoie les données via AJAX
            url: "prestations_update.php", // Le script côté serveur qui gère la mise à jour
            type: "POST",
            data: {id: id, designation: designation, prix: prix, description: description,
            },
            success: function (data) {
                $("#result_prestation").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affPrestations(); $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                $("#result_prestation").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Prestation /////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////// Start Stock ///////////////////////////////////////////////////////////////////////////////////////////
// Aff Stock
function affStocks(){
    $.ajax({
        url: "stock_read.php",
        type: "post",
        success: function(data) {
            $("#affStock").html(data);
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
                $("#result_stock").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affStocks(); $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_stock").html('<div class="alert alert-danger">Erreur lors de la mis à jour du stock.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Stock /////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// Start Vehicule /////////////////////////////////////////////////////////////////////////////////////////
// Add Vehicule
$(document).on('click', '#btn_add_vehicule', function(e){
    e.preventDefault();
    var nom = $("#nom").val();
    if (nom.trim() !== "") {
        $.ajax({
            url: "vehicule_add.php",
            type: "POST",
            data: {nom: nom,},
            success: function(data){
                $("#result_vehicule").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affVehicules(); $("#exampleModalAdd").modal("hide");
            },
            error: function(){$("#result_vehicule").html('<div class="alert alert-danger">Erreur lors de l\'ajout du prestataire.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
        });
        $('#exampleModalAdd').modal('hide');
    } else {$("#result_vehicule").html('<div class="alert alert-warning">Les champs ne peuvent pas être vide.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);}
});
// Aff Vehicule
function affVehicules(){
    $.ajax({
        url: "vehicule_read.php",
        type: "post",
        success: function(data) {
            $("#affVehicule").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erreur lors de la récupération des véhicules :', textStatus, errorThrown);
            $("#affVehicule").html('<div class="alert alert-danger">Erreur lors du chargement des véhicules.</div>');
        }
    });
}
affVehicules();
//Supprimer Vehicule
$(document).on('click', '.btn_del_vehicule', function(e){
    e.preventDefault();
    if (window.confirm("Voulez-vous supprimer ce véhicule?")) {
        var v_id = $(this).data("id");
        $.ajax({
            url: "vehicule_delete.php",
            type: "POST",
            data: { id: v_id },
            success: function(response) {
                $("#result_vehicule").html(response).delay(700).slideDown(700).delay(2100).slideUp(700);
                affVehicules();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erreur lors de la suppression :', textStatus, errorThrown);
                $("#result_vehicule").html('<div class="alert alert-danger">Erreur lors de la suppression du véhicule.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            }
        });
    } else {return false;}
});
//Fonction pour modifier le Vehicule
function updateVehicule() {
    $(document).on("click", "#btn_up_vehicule", function (e) {
        e.preventDefault();
        var vehiculeId  = $(this).attr("value");
        $.ajax({
            url:"vehicule_mod.php",
            type:"POST",
            data:{ id: vehiculeId  },
            success: function(response){
                $("#vehicule_mod").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors du chargement du formulaire :", error);
            }
        });
    });
}
updateVehicule();
//fonction de mise a jour Vehicule
$(document).ready(function () {
    // Capture le clic sur le bouton de mise à jour
    $(document).on("click", "#btn_maj_vehicule", function (e) {
        e.preventDefault(); // Empêche le comportement par défaut
        var id = $("#vehicule_id").val(); var nom = $("#vehicule_nom").val(); // Récupère les données du formulaire
        $.ajax({ // Envoie les données via AJAX
            url: "vehicule_update.php", // Le script côté serveur qui gère la mise à jour
            type: "POST",
            data: {id: id, nom: nom },
            success: function (data) {
                $("#result_vehicule").html(data).delay(700).slideDown(700).delay(2100).slideUp(700);
                affVehicules(); $("#exampleModalMaj").modal("hide");
            },
            error: function (xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", error);
                $("#result_vehicule").html('<div class="alert alert-danger">Erreur lors de la mis à jour.</div>').delay(700).slideDown(700).delay(2100).slideUp(700);
            },
        });
    });
});
///////////////////////////////////////////////////////////////// End Vehicule //////////////////////////////////////////////////////////////////////////////////////////