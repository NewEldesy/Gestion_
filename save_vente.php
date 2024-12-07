<!-- <script>
    var test = <?php echo json_encode($_POST); ?>;
    alert(JSON.stringify(test));
</script> -->

<?php
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST;
    // Assurez-vous que $data est bien formaté
    if (isset($data['venteId']) && isset($data['remise']) && isset($data['total']) && isset($data['items']) && isset($data['statuts'])) {
        $transactionId = addVente($data);
        echo '<div class="alert alert-success" role="alert">
                  Vente enregistré avec succès</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                    Enregistrement échoué</div>';
    }
}