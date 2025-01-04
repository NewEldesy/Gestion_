<?php
session_start();
include_once('model.php');

// Vérifier si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées depuis le frontend
    $username = isset($_POST['Email1']) ? trim($_POST['Email1']) : '';
    $password = isset($_POST['Password1']) ? trim($_POST['Password1']) : '';
    
    // Valider les champs (s'assurer qu'ils ne sont pas vides)
    if (empty($username) || empty($password)) {
        echo '<div class="alert alert-warning text-center">Les champs ne peuvent pas être vides.</div>';
        exit();
    }

    // Appeler la fonction try_login pour vérifier l'existence de l'utilisateur
    $user = try_login($username);

    // Si l'utilisateur est trouvé, comparer le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Le mot de passe est correct, démarrer la session ou envoyer une réponse de succès
        $_SESSION['user_id'] = $user['id'];  // Stocker l'ID de l'utilisateur dans la session
        $_SESSION['user_email'] = $user['email'];  // Stocker l'email dans la session
        $_SESSION['user_username'] = $user['username']; // Stocker l'username dans la session Connexion réussie

        // echo '<div class="alert alert-success text-center">Connexion réussie !</div>';
        echo json_encode([
            'status' => 'success',
            'message' => 'Connexion réussie !'
        ]);
    } else {
        // echo '<div class="alert alert-danger text-center">Mot de passe incorrect.</div>';
        echo json_encode([
            'status' => 'danger',
            'message' => 'Mot de passe incorrect.'
        ]);
        session_destroy(); exit();
    }
}
?>