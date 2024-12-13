<?php
// Démarrer la session
session_start();

// Inclure la configuration pour la base de données
require_once 'C:/xampp/htdocs/test solo/config.php';

// Connexion à la base de données
$pdo = DatabaseConfig::getConnexion();

// Récupérer l'ID du panier depuis la requête GET
if (!isset($_GET['idpanier'])) {
    die("ID du panier non spécifié.");
}

$idpanier = $_GET['idpanier'];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse = $_POST['adresse'];

    // Vérifier que l'adresse n'est pas vide
    if (empty($adresse)) {
        echo "<script>alert('L\'adresse saisie n\'est pas valide.');</script>";
    } else {
        try {
            // Insérer la commande dans la table commande
            $stmt = $pdo->prepare("INSERT INTO commande (idpanier, datecommande, adresse) VALUES (:idpanier, NOW(), :adresse)");
            $stmt->execute([
                ':idpanier' => $idpanier,
                ':adresse' => $adresse
            ]);

            // Supprimer le panier de la table panier
            $stmt = $pdo->prepare("DELETE FROM panier WHERE idpanier = :idpanier");
            $stmt->execute([
                ':idpanier' => $idpanier
            ]);

            // Rediriger vers la page d'historique des paniers ou une autre page
            header("Location: produit.php?status=commande_confirmee");
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmer la Commande</title>
    <link rel="stylesheet" href="commande.css">
    <script>
        // Fonction pour valider le formulaire
        function validerFormulaire(event) {
            // Récupérer la valeur du champ adresse
            const adresse = document.getElementById('adresse').value.trim();

            // Vérifier si le champ est vide
            if (adresse === '') {
                event.preventDefault(); // Empêcher la soumission du formulaire
                alert("Votre adresse n'est pas valide."); // Afficher une alerte
                document.getElementById('adresse').focus(); // Mettre le focus sur le champ
            }
        }
    </script>
</head>
<body>
    <h1>Confirmer la Commande</h1>
    <p>ID du Panier : <strong><?php echo htmlspecialchars($idpanier); ?></strong></p>
    <form method="POST" onsubmit="validerFormulaire(event);">
        <label for="adresse">Adresse de livraison :</label><br>
        <input type="text" id="adresse" name="adresse"><br><br>
        <button type="submit">Valider la Commande</button>
    </form>
</body>
</html>
