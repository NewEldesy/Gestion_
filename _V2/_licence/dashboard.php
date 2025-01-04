<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Vérification de la licence active
$db = new PDO('sqlite:../BDD/Gestion.db');
$stmt = $db->prepare("
    SELECT A.status, A.date_fin
    FROM licence_active A
    JOIN licence L ON A.id_licence = L.id
    WHERE A.status = 'active' AND date('now') <= A.date_fin
");
$stmt->execute();
$licence = $stmt->fetch();

if (!$licence) {
    header('Location: licence.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue, <?=$_SESSION['prenom'];?> <?=$_SESSION['nom'];?></h1>
    <p>Votre licence est active jusqu'au : 
        <?php
            $date = $licence['date_fin'];
            $dateObject = DateTime::createFromFormat('Y-m-d', $date);
            $formattedDate = $dateObject->format('d-m-Y');
            echo $formattedDate;
        ?>
    </p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>