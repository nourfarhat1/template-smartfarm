<?php
// Inclure le fichier de connexion à la base de données
include_once 'C:/xampp/htdocs/projet23/projet/app/config/db.php';  // Assurez-vous que le chemin est correct

// Vérifier si le paramètre 'id' est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtenir la connexion à la base de données
    $conn = Database::getConnexion();  // Utilisez cette méthode si votre classe Database est configurée de cette manière

    // Vérifiez si la connexion est établie correctement
    if ($conn) {
        // Préparer la requête SQL pour supprimer la réponse
        $sql = "DELETE FROM reponse WHERE id = :id";

        if ($stmt = $conn->prepare($sql)) {
            // Lier le paramètre avec bindValue
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            // Exécuter la requête
            if ($stmt->execute()) {
                // Rediriger vers la liste des réponses après la suppression
                header("Location:http://localhost:5500");
                exit();
            } else {
                echo "Erreur lors de la suppression de la réponse: " . $conn->errorInfo();
            }

            // Fermer la déclaration
            $stmt->closeCursor();
        } else {
            echo "Erreur lors de la préparation de la requête: " . $conn->errorInfo();
        }

        // Fermer la connexion
        $conn = null;
    } else {
        echo "Erreur de connexion à la base de données.";
    }
}
?>
