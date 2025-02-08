<?php
header('Content-Type: application/json');
session_start();
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $newPassword = $_POST['password2'];

    if (empty($newPassword)) {
        echo json_encode([
            'status' => 'danger',
            'message' => 'Le mot de passe ne peut pas être vide.',
        ]);
        exit();
    }

    // Hashage du nouveau mot de passe
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Mise à jour dans la base de données
    $database = dbConnect();
    $stmt = $database->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Mot de passe mis à jour avec succès.',
        ]);
    } else {
        echo json_encode([
            'status' => 'danger',
            'message' => 'Une erreur est survenue lors de la mise à jour.',
        ]);
    }
}
?>