<?php
// Informations de connexion
$servername = "localhost"; // Adresse du serveur 
$username = "root";        // Nom d'utilisateur 
$password = "";            // Mot de passe 
$dbname = "smartfarm";     // Nom de votre base de données

// Tentative de connexion
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configuration pour les erreurs PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données!";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
