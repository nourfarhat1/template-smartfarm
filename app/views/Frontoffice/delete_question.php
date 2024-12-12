<?php
// Inclure le fichier de configuration et le contrôleur
include_once '../../controllers/QuestionController.php'; // Inclure le contrôleur de question

// Vérifier si l'ID est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID de la question à supprimer
    $id = (int) $_GET['id'];  // Convertir l'ID en entier

    // Créer une instance du contrôleur
    $controller = new QuestionController();

    // Appeler la méthode du contrôleur pour supprimer la question
    $controller->deleteQuestion($id);

    // Rediriger vers la liste des questions avec un message de succès
    header('Location:http://localhost:5500/?status=success&message=Question%20supprimée%20avec%20succès');
    exit(); // Assurez-vous d'arrêter l'exécution du script
} else {
    // Si l'ID n'est pas passé, rediriger vers la liste des questions avec un message d'erreur
    header('Location:http://localhost:5500/?status=error&message=Aucun%20ID%20de%20question%20fourni');
    exit();
}
?>
