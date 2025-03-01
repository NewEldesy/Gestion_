<?php
session_start();
$db = new PDO('sqlite:../BDD/Gestion.db');

// Rédirection vers l'application si les session existent déjà
// if (isset($_SESSION)) {
//     header('Location: dashboard.php');
//     exit();
// }

// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];

        // Vérifier l'état de la licence
        $stmt = $db->prepare("
            SELECT A.status, A.date_fin
            FROM licence_active A
            JOIN licence L ON A.id_licence = L.id
            WHERE A.status = 'active' AND date('now') <= A.date_fin
        ");
        $stmt->execute();
        $licence = $stmt->fetch();

        if ($licence) {
            header('Location: dashboard.php');
        } else {
            header('Location: licence.php');
        }
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required />
        <input type="password" name="password" placeholder="Mot de passe" required />
        <button type="submit" name="submit">Se connecter</button>
    </form>
</body>
</html>