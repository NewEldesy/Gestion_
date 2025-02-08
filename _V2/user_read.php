<?php
include_once('model.php');
$database = dbConnect();

$stmt = $database->prepare("SELECT * FROM users");
$stmt->execute(); $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h5 class="mb-5">Liste Utilisateur</h5>
<table class="table align-middle mb-0 p-5" id="User">
    <thead>
        <tr class="border-2 border-bottom border-primary border-0"> 
            <th scope="col" class="ps-0">#</th>
            <th scope="col" class="text-center">Nom(s)</th>
            <th scope="col" class="text-center">Prenom(s)</th>
            <th scope="col" class="text-center">Username</th>
            <th scope="col" class="text-center">Options</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php if (!empty($users)) {
            foreach ($users as $user) { ?>
        <tr>
            <th scope="row" class="text-center fw-medium"><?=htmlspecialchars($user['id']);?></th>
            <td scope="row" class="text-center fw-medium"><?=htmlspecialchars($user['nom']);?></td>
            <th scope="row" class="text-center fw-medium"><?=htmlspecialchars($user['prenom']);?></th>
            <th scope="row" class="text-center fw-medium"><?=htmlspecialchars($user['username']);?></th>
            <td>
                <a href="#" class="btn_del_user btn btn-sm btn-danger" data-id="<?=$user['id'];?>">Supprimer</a>
                <a href="#" id="btn_up_user" data-bs-toggle="modal" data-bs-target="#exampleModalMaj" value="<?=$user['id'];?>" class="btn btn-sm btn-warning"></i>Modifier</a>
            </td>
        </tr>
        <?php } 
            } else { ?>
                <tr>
                    <td colspan="6" class="text-center">
                    <div class="alert alert-warning" role="alert">
                        Pas d'utilisateurs' enregistrés !!!
                    </div>
                    </td>
                </tr>
        <?php } ?>
    </tbody>
</table>

<script> new DataTable('#User'); </script>