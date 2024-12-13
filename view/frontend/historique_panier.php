<?php
// Démarrer la session
session_start();

// Inclure la configuration pour la base de données
require_once 'C:/xampp/htdocs/test solo/config.php';

// Connexion à la base de données
$pdo = DatabaseConfig::getConnexion();

try {
    // Supprimer automatiquement les paniers avec un montant total de 0
    $stmt = $pdo->prepare("DELETE FROM panier WHERE montant = 0");
    $stmt->execute();
} catch (PDOException $e) {
    echo "Erreur lors de la suppression automatique des paniers : " . $e->getMessage();
}

// Vérifier si un panier a été supprimé manuellement
if (isset($_POST['supprimer_panier'])) {
    $idpanierASupprimer = $_POST['supprimer_panier'];

    try {
        // Commencer une transaction
        $pdo->beginTransaction();

        // Supprimer les produits associés à ce panier
        $stmt = $pdo->prepare("DELETE FROM panier WHERE idpanier = :idpanier");
        $stmt->execute([ ':idpanier' => $idpanierASupprimer ]);

        // Commit de la transaction
        $pdo->commit();

        // Rediriger vers la page historique des paniers après la suppression
        header("Location: historique_panier.php?status=deleted");
        exit();
    } catch (PDOException $e) {
        // Rollback de la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Erreur: " . $e->getMessage();
    }
}

// Récupérer l'historique des paniers
$stmt = $pdo->prepare("SELECT * FROM panier WHERE idpanier IS NOT NULL GROUP BY idpanier");
$stmt->execute();
$paniers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Paniers</title>
    <link rel="stylesheet" href="historique.css">
</head>
<body>

    <h1>Historique des Paniers</h1>

    <!-- Afficher un message si un panier a été supprimé -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
        <p>Le panier a été supprimé avec succès.</p>
    <?php endif; ?>

    <?php if (empty($paniers)): ?>
        <p>Vous n'avez aucun panier enregistré.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Panier</th>
                    <th>Montant Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paniers as $panier): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($panier['idpanier']); ?></td>
                        <td><?php echo htmlspecialchars($panier['montant']); ?> dt</td>
                        <td>
                            <!-- Voir Détails -->
                            <a href="detail_panier.php?idpanier=<?php echo $panier['idpanier']; ?>">Voir Détails</a>
                            
                            <!-- Modifier -->
                            <a href="modifier_panier.php?idpanier=<?php echo $panier['idpanier']; ?>">Modifier</a>
                            
                            <!-- Supprimer -->
                            <form method="POST" style="display:inline;">
                                <button type="submit" name="supprimer_panier" value="<?php echo $panier['idpanier']; ?>">Supprimer</button>
                            </form>

                            <!-- Confirmer la commande -->
                            <a href="commande.php?idpanier=<?php echo $panier['idpanier']; ?>"><button>Confirmer la commande</button></a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
