<?php
// Récupérer les données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Connexion à la base de données
$pdo = new PDO('mysql:host=HOST;dbname=DATABASE', 'USERNAME', 'PASSWORD');

// Préparer la requête de sélection
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// Vérifier si l'utilisateur existe et si le mot de passe est correct
if ($user && password_verify($password, $user['password'])) {
    // L'utilisateur est connecté, rediriger vers une page sécurisée
    header("Location: page_securisee.php");
} else {
    // Afficher un message d'erreur
    echo "Email ou mot de passe incorrect.";
}
?>
