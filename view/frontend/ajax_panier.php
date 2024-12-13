<?php
session_start();
require_once 'C:/xampp/htdocs/test solo/config.php';

// Vérifier si le panier est initialisé
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Vérifier l'action envoyée via AJAX
$action = $_POST['action'] ?? '';
$idproduit = $_POST['idproduit'] ?? null;

$response = ['html' => '', 'message' => '', 'success' => false];

if ($action === 'increment') {
    if ($idproduit && isset($_SESSION['panier'][$idproduit])) {
        $_SESSION['panier'][$idproduit]['quantitepan'] += 1;
    }
} elseif ($action === 'decrement') {
    if ($idproduit && isset($_SESSION['panier'][$idproduit])) {
        if ($_SESSION['panier'][$idproduit]['quantitepan'] > 1) {
            $_SESSION['panier'][$idproduit]['quantitepan'] -= 1;
        } else {
            unset($_SESSION['panier'][$idproduit]);
        }
    }
} elseif ($action === 'supprimer') {
    if ($idproduit && isset($_SESSION['panier'][$idproduit])) {
        unset($_SESSION['panier'][$idproduit]);
    }
} elseif ($action === 'enregistrer_panier') {
    // Enregistrement du panier dans la base de données
    if (empty($_SESSION['panier'])) {
        $response['message'] = "Le panier est vide.";
    } else {
        $pdo = DatabaseConfig::getConnexion();
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO panier (idpanier, montant) VALUES (:idpanier, :montant)");
            $idpanier = uniqid();
            $total = 0;

            foreach ($_SESSION['panier'] as $produit) {
                $total += $produit['prix'] * $produit['quantitepan'];
            }

            $stmt->execute([':idpanier' => $idpanier, ':montant' => $total]);

            foreach ($_SESSION['panier'] as $idproduit => $details) {
                $montantProduit = $details['prix'] * $details['quantitepan'];
                $stmt = $pdo->prepare("INSERT INTO panier (idpanier, idproduit, quantitepan, montant) 
                                       VALUES (:idpanier, :idproduit, :quantitepan, :montant)");
                $stmt->execute([
                    ':idpanier' => $idpanier,
                    ':idproduit' => $idproduit,
                    ':quantitepan' => $details['quantitepan'],
                    ':montant' => $montantProduit
                ]);
            }

            $pdo->commit();
            unset($_SESSION['panier']);
            $response['message'] = "Panier enregistré avec succès.";
            $response['success'] = true;
        } catch (PDOException $e) {
            $pdo->rollBack();
            $response['message'] = "Erreur : " . $e->getMessage();
        }
    }
}

// Calculer le nouveau total
$total = 0;
foreach ($_SESSION['panier'] as $produit) {
    $total += $produit['prix'] * $produit['quantitepan'];
}

// Générer le nouveau contenu HTML du panier
ob_start();
include 'ajax_panier_content.php';
$response['html'] = ob_get_clean();

// Envoyer la réponse au client
header('Content-Type: application/json');
echo json_encode($response);
