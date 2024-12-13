<?php
// Inclure la configuration de la base de données
require_once '../../config.php'; // Inclure correctement le fichier de configuration

// Connexion à la base de données via la méthode statique de DatabaseConfig
$pdo = DatabaseConfig::getConnexion();

// Exemple d'une requête SQL pour récupérer des produits
$sql = "SELECT * FROM produit";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$idproduit = $stmt->fetchAll();
?>
