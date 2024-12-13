<?php
// Commencer la session
session_start();

// Vérifier si l'ID du produit est passé
if (isset($_POST['idproduit'])) {
    $idproduit = $_POST['idproduit'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];

    // Ajouter ou modifier le produit dans le panier
    if (!isset($_SESSION['panier'][$idproduit])) {
        $_SESSION['panier'][$idproduit] = [
            'nom' => $nom,
            'prix' => $prix,
            'quantitepan' => 1
        ];
    } else {
        $_SESSION['panier'][$idproduit]['quantitepan'] += 1; // Incrémente la quantité si déjà dans le panier
    }

    // Retourner à la page produit sans redirection vers le panier
    // Ici, tu peux rediriger vers la même page produit (ou une autre page) après l'ajout
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
