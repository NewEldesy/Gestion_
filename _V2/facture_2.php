<?php include_once('header.php');?>
<style>
    @media print {
        body {
            margin: 0;
            padding: 0;
            width: 210mm; /* Largeur A4 */
            height: 297mm; /* Hauteur A4 */
        }

        #divName {
            width: 100%; /* Assurez que le contenu occupe toute la largeur */
        }

        /* Supprime les marges pour l'impression */
        @page {
            size: A4; /* Définit la taille de la page */
            margin: 10mm; /* Définit une marge de 10mm (modifiable) */
        }
    }
</style>

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
                                    <h5 class="mb-0">Facture N° <?php echo $_GET['id']; ?></h5>
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
                                    <td style="text-align: left; font-size: 13px;"><strong>Client : John Doe</strong></td>
                                    <td style="text-align: right; font-size: 13px;"><strong>Addresse : Tenkodogo</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: left; font-size: 13px;"><strong>RCCM : 00000000</strong></td>
                                    <td style="text-align: right; font-size: 13px;"><strong>IFU : 00000000</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="text-align: left; font-size: 13px;"><strong>BP : 5124</strong></td>
                                    <td style="text-align: right; font-size: 13px;"><strong>Téléphone : 00000000</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <h6>Description : Vente Produits</h6>
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
                            <tr>
                                <td class="center">1</td>
                                <td class="left strong">Iphone 10X</td>
                                <td class="right">1500 FCFA</td>
                                <td class="center">10</td>
                                <td class="right">15.000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="center">2</td>
                                <td class="left">Iphone 8X</td>
                                <td class="right">1200 FCFA</td>
                                <td class="center">10</td>
                                <td class="right">12.000 FCFA</td>
                            </tr>
                            <tr>
                                <td class="center">3</td>
                                <td class="left">Samsung 4C</td>
                                <td class="right">800 FCFA</td>
                                <td class="center">10</td>
                                <td class="right">8000 FCFA</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6"></div>
                    <div class="col-lg-6 col-sm-6 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Sous total</strong>
                                    </td>
                                    <td class="right">28.809,00 FCFA</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Remise (20%)</strong>
                                    </td>
                                    <td class="right">5.761,00 FCFA</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">TVA (19%)</strong>
                                    </td>
                                    <td class="right">2.304,00 FCFA</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong class="text-dark">20.744,00 FCFA</strong>
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

<?php include_once('footer.php');?>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>