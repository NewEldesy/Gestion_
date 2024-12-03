<!-- Impression des prestations -->

<?php
include_once('model.php');
$database = dbConnect();

// Fonction pour récupérer les données d'une table
function fetchTableData($database, $query) {
    $stmt = $database->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Connexion à la base de données
$database = dbConnect();

// Requêtes pour chaque table
$queryMechanics = "SELECT * FROM Mecaniques"; // Table des prestations mécaniques
$queryTractage = "SELECT * FROM Tractage"; // Table des prestations de tractage
$queryAutre = "SELECT * FROM AutreP"; // Table des autres prestations

// Récupérer les données
$dataMechanics = fetchTableData($database, $queryMechanics);
$dataTractage = fetchTableData($database, $queryTractage);
$dataAutre = fetchTableData($database, $queryAutre);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impression des Prestations</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <button id="btnPrint">Imprimer</button>

    <div id="printSection">
        <h1>Prestations Mécaniques</h1>
        <table>
            <tr>
                <th>#</th>
                <th>N° Immatriculation</th>
                <th>Marque Véhicule</th>
                <th>Contact Propriétaire</th>
                <th>Montant</th>
                <th>Date Entrée</th>
                <th>Date Sortie</th>
                <th>Prestataire</th>
                <th>Observation</th>
            </tr>
            <?php foreach ($dataMechanics as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['num_immatriculation']) ?></td>
                    <td><?= htmlspecialchars($row['vehicule']) ?></td>
                    <td><?= htmlspecialchars($row['proprietaire_contact']) ?></td>
                    <td><?= htmlspecialchars($row['montant']) ?></td>
                    <td><?= htmlspecialchars($row['date_entree']) ?></td>
                    <td><?= htmlspecialchars($row['date_sortie']) ?></td>
                    <td><?= htmlspecialchars($row['prestataire']) ?></td>
                    <td><?= htmlspecialchars($row['observation']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h1>Prestations Tractage</h1>
        <table>
            <tr>
                <th>#</th>
                <th>N° Immatriculation</th>
                <th>Marque Véhicule</th>
                <th>Contact Propriétaire</th>
                <th>Lieu</th>
                <th>Date Tractage</th>
                <th>Montant</th>
                <th>Prestataire</th>
                <th>Observation</th>
            </tr>
            <?php foreach ($dataTractage as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['num_immatriculation']) ?></td>
                    <td><?= htmlspecialchars($row['vehicule']) ?></td>
                    <td><?= htmlspecialchars($row['proprietaire_contact']) ?></td>
                    <td><?= htmlspecialchars($row['lieu_kilometrage']) ?></td>
                    <td><?= htmlspecialchars($row['date_entree']) ?></td>
                    <td><?= htmlspecialchars($row['montant']) ?></td>
                    <td><?= htmlspecialchars($row['prestataire']) ?></td>
                    <td><?= htmlspecialchars($row['observation']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h1>Autres Prestations</h1>
        <table>
            <tr>
                <th>#</th>
                <th>N° Immatriculation</th>
                <th>Marque Véhicule</th>
                <th>Contact Propriétaire</th>
                <th>Type Prestation</th>
                <th>Montant</th>
                <th>Date Entrée</th>
                <th>Prestataire</th>
                <th>Observation</th>
            </tr>
            <?php foreach ($dataAutre as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['num_immatriculation']) ?></td>
                    <td><?= htmlspecialchars($row['vehicule']) ?></td>
                    <td><?= htmlspecialchars($row['contact_proprietaire']) ?></td>
                    <td><?= htmlspecialchars($row['type_prestation']) ?></td>
                    <td><?= htmlspecialchars($row['montant']) ?></td>
                    <td><?= htmlspecialchars($row['date_entree']) ?></td>
                    <td><?= htmlspecialchars($row['prestataire']) ?></td>
                    <td><?= htmlspecialchars($row['observation']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>


    <script>
        // Fonction d'impression
        document.getElementById('btnPrint').addEventListener('click', function() {
            // Affiche uniquement la section pour impression
            const printContent = document.getElementById('printSection').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;

            // Recharge le JavaScript si nécessaire
            location.reload();
        });
    </script>
</body>
</html>