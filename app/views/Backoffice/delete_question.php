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

    // Après la suppression, rediriger l'utilisateur vers la liste des questions
    header('Location: allQuestions.php'); // Rediriger vers la page de la liste des questions
    exit(); // Assurez-vous d'arrêter l'exécution du script
} else {
    // Si l'ID n'est pas passé, rediriger vers la liste des questions
    header('Location: allQuestionss.php');
    exit();
}
?>
