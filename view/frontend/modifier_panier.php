<?php
// Démarrer la session
session_start();

// Inclure la configuration pour la base de données
require_once 'C:/xampp/htdocs/test solo/config.php';

// Vérifier si un panier spécifique est passé en paramètre
if (!isset($_GET['idpanier'])) {
    echo "Aucun panier spécifié.";
    exit();
}

$idpanier = $_GET['idpanier'];

// Connexion à la base de données
$pdo = DatabaseConfig::getConnexion();

// Gérer les actions POST (increment, decrement, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idproduit = $_POST['idproduit'] ?? null;

    if (isset($_POST['increment']) && $idproduit) {
        // Augmenter la quantité
        $stmt = $pdo->prepare("UPDATE panier SET quantitepan = quantitepan + 1 WHERE idpanier = :idpanier AND idproduit = :idproduit");
        $stmt->execute([':idpanier' => $idpanier, ':idproduit' => $idproduit]);
    } elseif (isset($_POST['decrement']) && $idproduit) {
        // Réduire la quantité si supérieure à 1
        $stmt = $pdo->prepare("UPDATE panier SET quantitepan = quantitepan - 1 WHERE idpanier = :idpanier AND idproduit = :idproduit AND quantitepan > 1");
        $stmt->execute([':idpanier' => $idpanier, ':idproduit' => $idproduit]);
    } elseif (isset($_POST['delete_product']) && $idproduit) {
        // Supprimer le produit du panier
        $stmt = $pdo->prepare("DELETE FROM panier WHERE idpanier = :idpanier AND idproduit = :idproduit");
        $stmt->execute([':idpanier' => $idpanier, ':idproduit' => $idproduit]);
    }

    // Recalculer le montant total après modification
    recalculerMontantTotal($idpanier, $pdo);

    // Recharger la page pour appliquer les modifications
    header("Location: modifier_panier.php?idpanier=$idpanier");
    exit();
}

// Récupérer les produits du panier spécifié
$stmt = $pdo->prepare("
    SELECT p.idproduit, p.quantitepan, pr.prix AS prix_unitaire, pr.nom AS nom_produit, 
           (p.quantitepan * pr.prix) AS montant
    FROM panier p
    JOIN produit pr ON p.idproduit = pr.idproduit
    WHERE p.idpanier = :idpanier AND p.idproduit IS NOT NULL
");
$stmt->execute([':idpanier' => $idpanier]);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculer le total du panier
$stmt = $pdo->prepare("
    SELECT SUM(pr.prix * p.quantitepan) AS total
    FROM panier p
    JOIN produit pr ON p.idproduit = pr.idproduit
    WHERE p.idpanier = :idpanier
");
$stmt->execute([':idpanier' => $idpanier]);
$total_panier = $stmt->fetchColumn();

// Fonction pour recalculer le montant total du panier
function recalculerMontantTotal($idpanier, $pdo) {
    $stmt = $pdo->prepare("
        SELECT SUM(pr.prix * p.quantitepan) AS total
        FROM panier p
        JOIN produit pr ON p.idproduit = pr.idproduit
        WHERE p.idpanier = :idpanier
    ");
    $stmt->execute([':idpanier' => $idpanier]);
    $total = $stmt->fetchColumn();

    $stmt = $pdo->prepare("UPDATE panier SET montant = :montant WHERE idpanier = :idpanier");
    $stmt->execute([':montant' => $total, ':idpanier' => $idpanier]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Panier</title>
    <link rel="stylesheet" href="panier.css">
</head>
<body>
    <h1>Modifier Panier : <?php echo htmlspecialchars($idpanier); ?></h1>

    <?php if (empty($produits)): ?>
        <p>Aucun produit dans ce panier.</p>
    <?php else: ?>
        <?php foreach ($produits as $produit): ?>
            <div>
                <p>Produit: <?php echo htmlspecialchars($produit['nom_produit']); ?> (ID: <?php echo htmlspecialchars($produit['idproduit']); ?>)</p>
                <p>
                    Quantité:
                    <form method="POST" style="display:inline;">
                        <button type="submit" name="decrement">-</button>
                        <input type="hidden" name="idproduit" value="<?php echo htmlspecialchars($produit['idproduit']); ?>">
                    </form>
                    <?php echo htmlspecialchars($produit['quantitepan']); ?>
                    <form method="POST" style="display:inline;">
                        <button type="submit" name="increment">+</button>
                        <input type="hidden" name="idproduit" value="<?php echo htmlspecialchars($produit['idproduit']); ?>">
                    </form>
                </p>
                <p>Total produit: <?php echo number_format($produit['montant'], 2); ?> dt</p>

                <!-- Bouton de suppression -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="idproduit" value="<?php echo htmlspecialchars($produit['idproduit']); ?>">
                    <button type="submit" name="delete_product">
                            <img src="trash.png" alt="Supprimer" style="width: 20px; height: 20px;">
                        </button>
                </form>
            </div>
        <?php endforeach; ?>

        <h2>Total du panier: <?php echo number_format($total_panier, 2); ?> dt</h2>
    <?php endif; ?>

    <!-- Bouton de confirmation -->
    <form method="POST" action="historique_panier.php">
        <button type="submit">Confirmer la modification</button>
    </form>
</body>
</html>
