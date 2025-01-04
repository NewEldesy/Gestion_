<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT m.id, m.date_entree, m.vehicule, m.num_immatriculation, m.proprietaire_contact, m.date_sortie, m.prestataire,
    m.observation, m.montant, v.nom AS vehicule_nom, p.nom AS prestataire_nom, p.prenom AS prestataire_prenom FROM Mecaniques m 
    LEFT JOIN vehicule v ON m.vehicule = v.id LEFT JOIN prestataire p ON m.prestataire = p.id");
$stmt->execute();
$Mecaniques = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste des Prestation Mécanique</h5>
<table class="table align-middle mb-0 p-2" id="PM">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">N° Immatriculation</th>
            <th scope="col" class="text-center">Marque Véhicule</th>
            <th scope="col" class="text-center">Contact Propriétaire</th>
            <th scope="col" class="text-center">Montant</th>
            <th scope="col" class="text-center">Date Entrée</th>
            <th scope="col" class="text-center">Date Sortie</th>
            <th scope="col" class="text-center">Prestataire</th>
            <th scope="col" class="text-center">Observation</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($Mecaniques)) {
            foreach ($Mecaniques as $pm) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($pm['id']);?></th>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['num_immatriculation']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['vehicule_nom']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['proprietaire_contact']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['montant']);?> FCFA</td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['date_entree']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['date_sortie']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['prestataire_nom']);?> <?=htmlspecialchars($pm['prestataire_prenom']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($pm['observation']);?></td>
            <td>
                <a href="#" class="btn_del_pm btn btn-sm btn-danger" data-id="<?=htmlspecialchars($pm['id']);?>">Supprimer</a>
                <a href="#" id="btn_up_pm" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?=htmlspecialchars($pm['id']);?>">Modifier</a>
            </td>
        </tr>
        <?php } 
            } else { ?>
                <tr>
                    <td colspan="9" class="text-center">
                    <div class="alert alert-warning" role="alert">
                        Pas de Prestations enregistré !
                    </div>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<script> new DataTable('#PM'); </script>