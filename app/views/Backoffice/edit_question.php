<?php
include_once '../../controllers/QuestionController.php'; // Inclure le contrôleur

// Vérifier si l'ID est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    $controller = new QuestionController();
    $question = $controller->showQuestion($_GET['id']);
}

// Vérifier si le formulaire a été soumis (méthode POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par le formulaire
    $id = (int) $_POST['id'];          // Convertir l'ID en entier
    $username = $_POST['username'];    // Nom d'utilisateur
    $email = $_POST['email'];          // Email
    $contenu = $_POST['contenu'];      // Contenu de la question

    // Créer un objet Question en passant les paramètres requis
    $questionToUpdate = new Question($id, $username, $contenu, $email);  // Passer les paramètres au constructeur

    // Créer une instance du contrôleur et mettre à jour la question
    $controller->updateQuestion($questionToUpdate, $id);  // Passer l'objet question et l'ID à la méthode

    // Après la mise à jour, rediriger l'utilisateur vers la liste des questions
    header('Location: allQuestions.php'); // Rediriger vers la page de la liste des questions
    exit();  // Assurez-vous d'arrêter l'exécution du script ici pour éviter d'afficher du texte inutile
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Question</title>
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

        .error {
            color: red;
            font-size: 12px;
        }
    </style>

    <script>
        // Fonction de validation du formulaire
        function validateForm() {
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var contenu = document.getElementById("contenu").value;
            var error = false;

            // Vider les précédentes erreurs
            document.getElementById("usernameError").textContent = '';
            document.getElementById("emailError").textContent = '';
            document.getElementById("contenuError").textContent = '';

            // Vérification que tous les champs sont remplis
            if (username.trim() === "") {
                document.getElementById("usernameError").textContent = "Le nom d'utilisateur est requis.";
                error = true;
            }

            if (email.trim() === "") {
                document.getElementById("emailError").textContent = "L'email est requis.";
                error = true;
            } else {
                // Validation de l'email
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                if (!emailPattern.test(email)) {
                    document.getElementById("emailError").textContent = "Veuillez entrer un email valide.";
                    error = true;
                }
            }

            if (contenu.trim() === "") {
                document.getElementById("contenuError").textContent = "Le contenu de la question est requis.";
                error = true;
            }

            // Si une erreur est trouvée, empêcher l'envoi du formulaire
            if (error) {
                return false;  // Empêche l'envoi du formulaire
            }

            return true;  // Permet l'envoi du formulaire si tout est correct
        }
    </script>
</head>
<body>
    <h1>Modifier une Question</h1>
    
    <!-- Formulaire de modification avec validation JS -->
    <form action="edit_question.php?id=<?= htmlspecialchars($question['id']) ?>" method="POST" onsubmit="return validateForm()">
        <input type="hidden" name="id" value="<?= htmlspecialchars($question['id']) ?>">

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($question['username']) ?>" required><br><br>
        <span id="usernameError" class="error"></span>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($question['email']) ?>" required><br><br>
        <span id="emailError" class="error"></span>

        <label for="contenu">Contenu :</label>
        <textarea id="contenu" name="contenu" rows="5" required><?= htmlspecialchars($question['contenu']) ?></textarea><br><br>
        <span id="contenuError" class="error"></span>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
