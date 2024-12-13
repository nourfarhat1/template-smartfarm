<?php
session_start();
require_once 'C:/xampp/htdocs/test solo/config.php';

// Vérifier si un idpanier a été passé dans l'URL
if (isset($_GET['idpanier'])) {
    $idpanier = $_GET['idpanier'];

    // Connexion à la base de données
    $pdo = DatabaseConfig::getConnexion();

    // Récupérer les détails du panier avec les informations des produits
    $stmt = $pdo->prepare("
        SELECT p.idproduit, pr.nom, p.quantitepan, pr.prix, (p.quantitepan * pr.prix) AS montant_total
        FROM panier p
        JOIN produit pr ON p.idproduit = pr.idproduit
        WHERE p.idpanier = :idpanier
    ");
    $stmt->execute([':idpanier' => $idpanier]);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Aucun panier sélectionné.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Panier</title>
    <link rel="stylesheet" href="detail.css">
</head>
<body>

    <h1>Détails du Panier : <?php echo htmlspecialchars($idpanier); ?></h1>

    <?php if (empty($produits)): ?>
        <p>Ce panier est vide ou n'existe pas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Produit</th>
                    <th>Nom</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produit['idproduit']); ?></td>
                        <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                        <td><?php echo htmlspecialchars($produit['quantitepan']); ?></td>
                        <td><?php echo number_format($produit['prix'], 2); ?> dt</td>
                        <td><?php echo number_format($produit['montant_total'], 2); ?> dt</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
