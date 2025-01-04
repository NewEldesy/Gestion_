<?php
include_once('model.php');
$database = dbConnect();

// Récupérer tous les véhicules depuis la base de données
$stmt = $database->prepare("SELECT t.id, t.date_entree, t.vehicule, t.num_immatriculation, t.proprietaire_contact, t.lieu_kilometrage, t.montant, 
    t.prestataire, t.observation, v.nom AS vehicule_nom, p.nom AS prestataire_nom, p.prenom AS prestataire_prenom FROM Tractage t
    LEFT JOIN vehicule v ON t.vehicule = v.id
    LEFT JOIN prestataire p ON t.prestataire = p.id");
$stmt->execute();
$tractages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste des Prestations Tractage</h5>
<table class="table align-middle mb-0 p-2" id="PT">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">N° Immatriculation</th>
            <th scope="col" class="text-center">Marque Véhicule</th>
            <th scope="col" class="text-center">Contact Propriétaire</th>
            <th scope="col" class="text-center">Lieu</th>
            <th scope="col" class="text-center">Date Tractage</th>
            <th scope="col" class="text-center">Montant</th>
            <th scope="col" class="text-center">Prestataire</th>
            <th scope="col" class="text-center">Observation</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($tractages)) {
            foreach ($tractages as $tractage) { ?>
        <tr>
            <th scope="row" class="ps-0 fw-medium"><?=htmlspecialchars($tractage['id']);?></th>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['num_immatriculation']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['vehicule_nom']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['proprietaire_contact']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['lieu_kilometrage']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['date_entree']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['montant']);?> XOF</td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['prestataire_nom']);?> <?=htmlspecialchars($tractage['prestataire_prenom']);?></td>
            <td class="text-center fw-medium"><?=htmlspecialchars($tractage['observation']);?></td>
            <td>
                <a href="#" class="btn_del_pt btn btn-sm btn-danger" data-id="<?=htmlspecialchars($tractage['id']);?>">Supprimer</a>
                <a href="#" id="btn_up_pt" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?=htmlspecialchars($tractage['id']);?>">Modifier</a>
            </td>
        </tr>
        <?php } 
            } else { ?>
                <tr>
                    <td colspan="10" class="text-center">
                    <div class="alert alert-warning" role="alert">
                        Pas de Prestations enregistré !
                    </div>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<script> new DataTable('#PT'); </script>