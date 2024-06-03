<?php

error_reporting(E_ALL); ini_set('display_errors', 1);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit; // Arrêter l'exécution du script
    }

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Connexion à la base de données MySQL
    $servername = "localhost";
    $username_db = "username_mysql";
    $password_db = "password_mysql";
    $dbname = "utilisateur_mysql";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }

    // Préparer la requête SQL d'insertion
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    // Préparer la déclaration
    $stmt = $conn->prepare($sql);

    // Liage des paramètres
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
    } else {
        echo "Erreur lors de l'inscription: " . $conn->error;
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>
