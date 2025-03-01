<?php
// generate_licenses.php
include_once('model.php');
// Connexion à la base de données
$db = dbConnect();

// Fonction pour générer une licence aléatoire
function generateLicense() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $license = '';
    for ($i = 0; $i < 16; $i++) {
        if ($i > 0 && $i % 4 === 0) {
            $license .= '-';
        }
        $license .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $license;
}

// Nombre de licences à générer
$numberOfLicenses = 30; // Vous pouvez modifier ce nombre
// Durée de validité en jours (par exemple, 365 jours pour 1 an)
$duree = 365;

// Générer et insérer les licences
for ($i = 0; $i < $numberOfLicenses; $i++) {
    $licenseNumber = generateLicense();
    $hashedLicense = hash('sha256', $licenseNumber); // Hacher la licence
    // Insérer la licence dans la table `licence`
    $stmt = $db->prepare("INSERT INTO licence (numero_licence, duree, statuts) VALUES (:numero_licence, :duree, 'non utilisé')");
    $stmt->bindParam(':numero_licence', $hashedLicense);
    $stmt->bindParam(':duree', $duree);
    $stmt->execute();
    echo "Licence générée : $licenseNumber (Hachée : $hashedLicense)<br>";
}

echo "$numberOfLicenses licences ont été générées et insérées dans la base de données.";
?>