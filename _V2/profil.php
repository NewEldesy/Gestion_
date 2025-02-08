<?php include_once('header.php'); ?>

        


      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title fw-semibold mb-4">Profil Utilisateur</h3>
          </div>
          <div class="card-body">
            <div id="result_profil">
            <form method="POST"></div>
                <input type="hidden" id="user_id" value="<?=$_SESSION['user_id'];?>">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" value="<?=$_SESSION['user_nom'];?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom(s)</label>
                    <input type="text" class="form-control" name="prenom" value="<?=$_SESSION['user_prenom'];?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" name="username" value="<?=$_SESSION['user_username'];?>" readonly>
                </div>
                <div class="mb-3">
                    <h3 class="fw-semibold mb-4">Changer mot de passe</h3>
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Saisir nouveau mot de passe</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
                <div class="mb-3">
                    <label for="password3" class="form-label">Répétez nouveau mot de passe</label>
                    <input type="password" class="form-control" id="password3" name="password3" required>
                </div>
                <button type="submit" id="mod_profil" class="btn btn-primary">Modifier</button>
            </form>
          </div>
        </div>
        

<?php include_once('footer.php'); ?>