<?php
session_start();
include_once('model.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['Email1']) ? trim($_POST['Email1']) : '';
    $password = isset($_POST['Password1']) ? trim($_POST['Password1']) : '';
    
    if (empty($username) || empty($password)) {
        echo '<div class="alert alert-warning text-center">Les champs ne peuvent pas être vides.</div>';
        exit();
    }
    
    $user = try_login($username);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_username'] = $user['username'];
        
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