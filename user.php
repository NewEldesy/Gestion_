<?php include_once('header.php'); ?>
<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['user_username']) || $_SESSION['user_username'] !== 'admin') {
    // Rediriger vers le tableau de bord avec un message d'erreur
    $_SESSION['error'] = "Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
    header('Location: dashboard.php'); // Utilisez une URL absolue
    exit();
}
?>


      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Gestion Utilisateurs</h3>
            <a href="#" id="addProd" data-bs-toggle="modal" data-bs-target="#exampleModalAdd" class="btn btn-primary">
              Nouvel Utilisateur
            </a>
          </div>
          <div class="card-body">
            <div id="result_user"></div>
            <div id="aff_user"></div>
          </div>
        </div>

        <!-- Modal Ajout -->
        <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="AddModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="AddModal">Enregistrement Utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST">
                  <div class="mb-3">
                    <label for="nom" class="form-label">Nom(s)</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                  </div>
                  <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom(s)</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                  </div>
                  <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <button type="submit" id="btn_add_user" class="btn btn-primary">Ajouter</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Ajout -->

        <!-- Modal Modification -->
        <div class="modal fade" id="exampleModalMaj" tabindex="-1" aria-labelledby="UpdateModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="UpdateModal">Modification Utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div id="user_mod"></div>
                <button type="submit" id="btn_maj_user" class="btn btn-primary">Modifier</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Modification -->
        

<?php include_once('footer.php'); ?>