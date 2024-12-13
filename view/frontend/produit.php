<?php
// Démarrer la session pour récupérer les informations du panier
session_start();

// Inclure le fichier backend pour récupérer les produits
require_once '../backend/getproduit.php'; // Remarquez l'utilisation de `../` pour remonter d'un niveau

// Connexion à la base de données
$db = DatabaseConfig::getConnexion();

// Obtenir tous les produits
$sql = "SELECT * FROM produit";
$stmt = $db->prepare($sql);
$stmt->execute();
$produits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cart-icon">
        <a href="panier.php"><img src="panier.png" alt="Panier" style="width: 50px; height: 50px;"></a>
        <span class="cart-counter" id="cart-counter"><?= isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0 ?></span>
    </div>

    <div class="container">
        <h1>Liste des produits</h1>

        <div class="products">
            <?php foreach ($produits as $produit): ?>
                <div class="product-box">
                    <div class="image-placeholder">Image</div>
                    <div class="product-details">
                        <h2><?php echo htmlspecialchars($produit['nom']); ?></h2>
                        <p>ID Produit: <?php echo htmlspecialchars($produit['idproduit']); ?></p>
                        <p>Prix: <?php echo htmlspecialchars($produit['prix']); ?> dt</p>
                        <form action="../backend/ajouterpanier.php" method="POST">
                            <input type="hidden" name="idproduit" value="<?= htmlspecialchars($produit['idproduit']); ?>">
                            <input type="hidden" name="nom" value="<?= htmlspecialchars($produit['nom']); ?>">
                            <input type="hidden" name="prix" value="<?= htmlspecialchars($produit['prix']); ?>">
                            <button type="submit">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    
</body>
</html>





