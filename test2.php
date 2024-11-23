<?php
// Connexion à la base de données
$pdo = new PDO('sqlite:BDD/Gestion.db');

// Récupérer toutes les catégories depuis la base de données
$stmt = $pdo->query("SELECT * FROM vehicule");
$vhs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialiser les variables pour éviter les erreurs
$categorie = ['nom' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Si l'on soumet le formulaire de modification
    if (isset($_POST['nom'])) {
        $id = (int)$_POST['id'];
        $nom = $_POST['nom'];

        // Mise à jour des informations dans la base de données
        $stmt = $pdo->prepare("UPDATE vehicule SET nom = :nom WHERE id = :id");
        $stmt->execute(['nom' => $nom, 'id' => $id]);
        // Redirection pour éviter la soumission multiple
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

    // Si l'on récupère les informations d'une catégorie pour les afficher dans le modal
    $id = (int)$_POST['id'];
    $stmt = $pdo->prepare("SELECT * FROM vehicule WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Catégories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Liste des Catégories</h2>

        <!-- Tableau des catégories -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vhs as $vh) { ?>
                    <tr>
                        <td><?= htmlspecialchars($vh['Id']); ?></td>
                        <td><?= htmlspecialchars($vh['nom']); ?></td>
                        <td>
                            <!-- Bouton pour ouvrir le modal avec l'id de la catégorie -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" 
                            data-id="<?= htmlspecialchars($vh['Id']); ?>"
                            data-nom="<?= htmlspecialchars($vh['nom']); ?>">Modifier</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Modal Modification catégorie -->
        <div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="UpdateModal">Modifier Vehicule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="id" id="category_id"> <!-- ID caché pour la mise à jour -->
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($categorie['nom']); ?>">
                            </div>
                            <button type="submit" id="btn_maj_cat" class="btn btn-primary">Modifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script Bootstrap et JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Quand le modal est ouvert, remplir les champs avec les données de la catégorie
        var modal = document.getElementById('exampleModalMaj');
        modal.addEventListener('show.bs.modal', function (event) {
            // Récupérer les données du bouton "Modifier"
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var nom = button.getAttribute('data-nom');

            // Remplir les champs du modal avec les données
            var categoryIdInput = modal.querySelector('#category_id');
            var nomInput = modal.querySelector('#nom');

            categoryIdInput.value = id;
            nomInput.value = nom;
        });
    </script>
</body>
</html>