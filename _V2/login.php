<?php
header('Content-Type: application/json');
session_start();
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['Email1']) ? trim($_POST['Email1']) : '';
    $password = isset($_POST['Password1']) ? trim($_POST['Password1']) : '';
    
    if (empty($username) || empty($password)) {
        echo json_encode([
            'status' => 'warning',
            'message' => 'Les champs ne peuvent pas être vides.'
        ]); exit();
    }
    
    $user = try_login($username);

    if (!$user) {
        echo json_encode([
            'status' => 'danger',
            'message' => 'Utilisateur non trouvé.'
        ]); exit();
    }
    
    if (password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id']; $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_nom'] = $user['nom']; $_SESSION['user_prenom'] = $user['prenom'];
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Connexion réussie !'
        ]);
    } else {
        echo json_encode([
            'status' => 'danger',
            'message' => 'Mot de passe incorrect.'
        ]);
        session_destroy(); exit();
    }
}
?>