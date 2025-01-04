<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Licence Inactive</title>
</head>
<body>
    <h1>Licence Inactive</h1>
    <p>Votre licence est expirée. Veuillez contacter le support pour renouveler ou activer une nouvelle licence.</p>
    <h3>Activé Licence</h3>
    <form method="POST" action="">
        <label for="licence">Code Licence</label>
        <input type="text" name="licence" id="licence">
        <button type="submit" name="submit">Vérifier</button>
    </form>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
