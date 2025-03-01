<?php 
    include_once('header.php');
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $elements = getElementPrestationById($id);
    if(!$elements){

        ?>
        <div id="myfrm" class="container-fluid">
            <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="mb-5 mt-5">
                                <div class="m-5">
                                    <?='<h3 style="text-align: center;">Aucune Prestation ne correspond à ce numéro de facturation</h3>';?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    else{
?>

<div class="container-fluid">
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
        <button class="btn btn-success" onclick="printDiv('myfrm')">Imprimer</button>
    </div>
</div>
<div id="myfrm" class="container-fluid">
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="card">
            <div class="card-body">
                <!-- Contenu du card-header déplacé ici -->
                <div class="p-2">
                    <div class="float-right">
                        <div style="text-align: center;" class="mb-2">
                            <img src="assets/images/Entete.png" alt="Garage Garango Paul - G.G.P." style="max-width: 100%; height: auto;">
                        </div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="text-align: left; font-size: 13px;">
                                    <h5 class="mb-0">Facture N° <?=$id;?></h5>
                                </td>
                                <td style="text-align: right; font-size: 13px;">
                                    <strong> Tenkodogo, 
                                        <?php setlocale(LC_TIME, 'fr_FR', 'fr'); echo strftime("%A %d %B %Y");?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Contenu principal de card-body -->
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: left; font-size: 13px;"><strong>Agrément : 2024-056</strong></td>
                                    <td style="text-align: right; font-size: 13px;"><strong>IFU : N°00051172 B</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: left; font-size: 13px;"><strong>BP : 30 Tenkodogo</strong></td>
                                    <td style="text-align: right; font-size: 13px;"><strong>Téléphone : (+226) 24 71 07 07</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: left; font-size: 13px;"><strong></strong></td>
                                    <td style="text-align: right; font-size: 13px;"><strong>Envoyer à : ........................................................................</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <h6>Description : Prestation de services</h6>
                <div class="table-responsive-sm" style="font-size: 13px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Produit</th>
                                <th class="right">Prix</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($elements as $element) {
                                    // Récupération des informations de prestation via l'ID
                                    $d = getPrestationsById($element['element_prestations']);
                                    ?>
                                    <tr>
                                        <!-- Affichage de l'index incrémenté -->
                                        <td class="center"><?= $i++; ?></td>
                                
                                        <!-- Affichage de la désignation de la prestation -->
                                        <td class="left strong"><?= htmlspecialchars($d['designation']); ?></td>
                                
                                        <!-- Affichage du prix -->
                                        <td class="right"><?= number_format($element['prix'], 2, ',', ' '); ?></td>
                                
                                        <!-- Quantité (fixée à 1 pour l'instant) -->
                                        <td class="center">1</td>
                                
                                        <!-- Sous-total (prix * quantité) -->
                                        <td class="right"><?= number_format($element['prix'], 2, ',', ' '); ?></td>
                                    </tr>
                                    <?php
                                }                                
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6"></div>
                    <div class="col-lg-6 col-sm-6 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <?php $tt = getPrestationById($id);?>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Sous total</strong>
                                    </td>
                                    <td class="right"><?=$tt['total']?> FCFA</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Remise</strong>
                                    </td>
                                    <td class="right"><?=$tt['remise']?>%</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">TVA (19%)</strong>
                                    </td>
                                    <td class="right">0 FCFA</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong class="text-dark"><?=($tt['total']*(1-($tt['remise']/100)))?> FCFA</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Contenu du card-footer déplacé ici -->
                <div class="bg-white mt-4">
                    <p class="mb-0" style="text-align: center; font-size: 13px;">C :N°BFTNK 2013 A 194 *** Agrément : 2024-056 *** IFU : N°00051172 B</p>
                    <p class="mb-0" style="text-align: center; font-size: 13px;">Compte N°005045840003-02 BOA N°170458699001-15 ECOBANK</p>
                    <p class="mb-0" style="text-align: center; font-size: 13px;">BP:30 Tenkodogo Tél: (+226) 24 71 07 07  Cel :(+226) 70 27 67 12 /76 96 08 04</p>
                    <p class="mb-0" style="text-align: center; font-size: 13px;">Mail : garagegarangopaul67@gmail.com / juliettekorgo@gmail.com Burkina Faso</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }
    include_once('footer.php');
?>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>