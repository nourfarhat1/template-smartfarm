<?php
// Inclure le fichier de connexion à la base de données et le contrôleur
include_once '../../controllers/ReponseController.php';  // Chemin ajusté

// Vérifier si l'ID est passé en GET
if (isset($_GET['id'])) {
    $controller = new ReponseController();
    $reponse = $controller->showReponse($_GET['id']);
    if (!$reponse) {
        // Si la réponse n'existe pas, rediriger vers la liste avec un message d'erreur
        header('Location:http://localhost:5500');
        exit();
    }
}

// Traitement du formulaire de modification
if (isset($_POST['id']) && isset($_POST['question_id']) && isset($_POST['contenu']) && isset($_POST['email'])) {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $question_id = $_POST['question_id'];
    $contenu = $_POST['contenu'];
    $email = $_POST['email'];

    // Créer une instance de la classe Reponse
    $reponse = new Reponse($id, $question_id, $contenu, $email);

    // Créer une instance du contrôleur
    $controller = new ReponseController();

    // Mettre à jour la réponse dans la base de données
    $updateSuccess = $controller->updateReponse($reponse, $id);

    // Rediriger immédiatement en cas de succès ou d'échec
    if ($updateSuccess) {
        header('Location:http://localhost:5500?success=true'); // Redirection vers la liste avec un paramètre de succès
        exit();
    } else {
        // Si une erreur se produit, rediriger vers la liste avec un message d'erreur
        header('Location:http://localhost:5500');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Réponse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #4CAF50; /* Vert */
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50; /* Vert */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #6b9e35; /* Légèrement plus foncé */
        }

        textarea {
            resize: vertical;
        }
    </style>

    <script>
        // Fonction de validation du formulaire
        function validateForm() {
            var questionId = document.getElementById("question_id").value;
            var contenu = document.getElementById("contenu").value;
            var email = document.getElementById("email").value;

            // Vérification que tous les champs sont remplis
            if (questionId.trim() === "") {
                alert("L'ID de la question est requis.");
                return false;
            }

            if (contenu.trim() === "") {
                alert("Le contenu de la réponse est requis.");
                return false;
            }

            if (email.trim() === "") {
                alert("L'email est requis.");
                return false;
            }

            // Validation de l'email avec une expression régulière
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                alert("Veuillez entrer un email valide.");
                return false;
            }

            // Si toutes les vérifications passent
            return true;
        }
    </script>
</head>
<body>
    <h1>Modifier une Réponse</h1>
    
    <form action="editAnswerForm.php?id=<?= $_GET['id'] ?>" method="POST" onsubmit="return validateForm()">
        <input type="hidden" name="id" value="<?= $reponse['id'] ?>">

        <label for="question_id">ID Question :</label>
        <input type="number" id="question_id" name="question_id" value="<?= $reponse['question_id'] ?>" required><br><br>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" rows="5" required><?= $reponse['contenu'] ?></textarea><br><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= $reponse['email'] ?>" required><br><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
