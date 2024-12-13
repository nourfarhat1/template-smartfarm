<?php
session_start();
include_once 'C:/xampp/htdocs/test solo/config.php'; // Inclure la configuration de la base de données

// Vérifie si le panier existe et contient des produits
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    // Connexion à la base de données
    $pdo = DatabaseConfig::getConnexion();

    // Si l'idpanier n'est pas déjà défini, on le crée
    if (!isset($_SESSION['idpanier'])) {
        $_SESSION['idpanier'] = uniqid('panier_');  // ID unique pour chaque panier
    }

    // Calculer le montant total du panier
    $totalPanier = 0;
    foreach ($_SESSION['panier'] as $details) {
        if ($details['quantitepan'] > 0) {
            $totalPanier += $details['prix'] * $details['quantitepan']; // Calcul du total
        }
    }

    // Supprimer les produits avec une quantité de 0 du panier
    foreach ($_SESSION['panier'] as $idproduit => $details) {
        if ($details['quantitepan'] <= 0) {
            unset($_SESSION['panier'][$idproduit]);
        }
    }

    // Vérifie si après nettoyage, le panier est vide
    if (empty($_SESSION['panier'])) {
        echo "Votre panier est vide. Aucune donnée à enregistrer.";
        exit();
    }

    // Commencer une transaction pour garantir que toutes les requêtes sont exécutées correctement
    try {
        $pdo->beginTransaction();

        // Enregistrer chaque produit du panier dans la table panier
        foreach ($_SESSION['panier'] as $idproduit => $details) {
            // Insérer une ligne pour chaque produit avec le même idpanier et le montant total
            $stmt = $pdo->prepare("INSERT INTO panier (idpanier, idproduit, quantitepan, montant) 
                                   VALUES (:idpanier, :idproduit, :quantitepan, :montant)");
            $stmt->execute([
                ':idpanier' => $_SESSION['idpanier'],  // Le même idpanier pour tous les produits
                ':idproduit' => $idproduit,  // L'id du produit actuel
                ':quantitepan' => $details['quantitepan'],  // Quantité du produit
                ':montant' => $totalPanier  // Le montant total du panier pour ce produit
            ]);
        }

        // Commit de la transaction
        $pdo->commit();

        // Vider le panier et l'identifiant de panier après enregistrement
        unset($_SESSION['panier']);
        unset($_SESSION['idpanier']);

        // Redirection vers la page panier avec un statut de succès
        echo "Votre panier a été enregistré avec succès.";
        exit();

    } catch (PDOException $e) {
        // Si une erreur se produit, annuler la transaction
        $pdo->rollBack();
        echo "Erreur: " . $e->getMessage();
    }
} else {
    echo "Votre panier est vide. Aucune donnée à enregistrer.";
}
?>
