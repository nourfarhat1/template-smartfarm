<?php
include_once __DIR__ . '/../../controllers/ReponseController.php';  // Inclure le contrôleur pour les réponses

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['response']) && isset($_POST['question_id']) && isset($_POST['email'])) {
        $response = $_POST['response'];
        $questionId = $_POST['question_id'];
        $email = $_POST['email'];  // Récupérer l'email

        // Créer une instance du contrôleur des réponses
        $reponseController = new ReponseController();

        // Appeler la méthode pour ajouter la réponse, incluant l'email
        $isAdded = $reponseController->addAnswer($questionId, $response, $email);

        // Vérifier si la réponse a été ajoutée avec succès
        if ($isAdded) {
            echo "<div class='success'>Réponse ajoutée avec succès!</div>";
        } 
    } else {
        echo "<div class='error'>Des données sont manquantes.</div>";
    }
}

?>
