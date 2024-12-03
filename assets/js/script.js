//fonction d'affichage du total des ventes
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

function updatePrestationTotals() {
    $.ajax({
        url: 'get_totalPs.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data && data.today !== undefined && data.week !== undefined && data.month !== undefined && data.year !== undefined) {
                $('#p_today').text(Number(data.today).toFixed(2));
                $('#p_week').text(Number(data.week).toFixed(2));
                $('#p_month').text(Number(data.month).toFixed(2));
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