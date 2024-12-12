<?php
// Inclure les fichiers nécessaires
include_once '../../controllers/QuestionController.php'; // Inclure le contrôleur de la question
$controller = new QuestionController();
$questions = $controller->listQuestions();
header('addQuestion.php');
// Vérifier si le formulaire a été soumis (méthode POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données envoyées par le formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contenu = $_POST['contenu'];

    // Créer un objet Question
    $question = new Question(null, $username, $contenu, $email);  // ID est null car ce sera une nouvelle question

    // Créer une instance du contrôleur
    $controller = new QuestionController();

    // Appeler la méthode du contrôleur pour ajouter la question
    $controller->addQuestion($question);

    // Rediriger l'utilisateur vers la liste des questions après l'ajout
    header('Location: addQuestion.php');  // Rediriger vers la page de la liste des questions
    exit(); // Assurez-vous d'arrêter l'exécution du script ici pour éviter d'afficher du texte inutile
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Question - SmartFarm</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1, header h2 {
            margin: 0;
        }

        /* Container principal */
        .main-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
            gap: 20px;
        }

        /* Formulaire */
        .form-container {
            flex: 1;
            min-width: 300px;
            max-width: 40%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .form-container input, .form-container textarea, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            border: none;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        /* Liste des questions */
        .questions-container {
            flex: 2;
            min-width: 300px;
            max-width: 55%;
        }

        .question-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        .question-card h3 {
            margin: 0 0 10px 0;
            color: #4CAF50;
        }

        .question-card p {
            margin: 0 0 5px 0;
        }

        .question-card small {
            color: #666;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        /* Animation pour les questions */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .form-container, .questions-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenue sur SmartFarm</h1>
        <h2>Ajouter une Question</h2>
    </header>

    <div class="main-container">
        <!-- Formulaire de création de la question -->
        <div class="form-container">
            <form id="addQuestionForm" action="addQuestion.php" method="POST" onsubmit="return validateForm();">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur">
                <div class="error" id="usernameError"></div>

                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email">
                <div class="error" id="emailError"></div>

                <label for="contenu">Contenu :</label>
                <textarea id="contenu" name="contenu" rows="5" placeholder="Écrivez le contenu de la question"></textarea>
                <div class="error" id="contenuError"></div>

                <button type="submit">Ajouter</button>
            </form>
            <button type="button" onclick="history.back();" style="margin-top: 10px; padding: 10px; background-color: #ccc; border: none; border-radius: 5px; cursor: pointer;">
        Retour à la page précédente
    </button>
        </div>

        <!-- Liste des questions -->
        <div class="questions-container">
            <h2>Liste des Questions</h2>
            <?php if (!empty($questions)) : ?>
                <?php foreach ($questions as $question) : ?>
                    <div class="question-card">
                        <h3><?= htmlspecialchars($question['username']); ?></h3>
                        <p><?= htmlspecialchars($question['contenu']); ?></p>
                        <small>Email: <?= htmlspecialchars($question['email']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucune question n'a été ajoutée pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function validateForm() {
            let isValid = true;

            // Récupérer les champs du formulaire
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const contenu = document.getElementById('contenu');

            // Récupérer les conteneurs d'erreur
            const usernameError = document.getElementById('usernameError');
            const emailError = document.getElementById('emailError');
            const contenuError = document.getElementById('contenuError');

            // Réinitialiser les messages d'erreur
            usernameError.textContent = '';
            emailError.textContent = '';
            contenuError.textContent = '';

            // Validation du nom d'utilisateur
            if (username.value.trim() === '') {
                usernameError.textContent = 'Le nom d\'utilisateur est requis.';
                isValid = false;
            }

            // Validation de l'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === '') {
                emailError.textContent = 'L\'email est requis.';
                isValid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                emailError.textContent = 'Veuillez entrer une adresse email valide.';
                isValid = false;
            }

            // Validation du contenu
            if (contenu.value.trim() === '') {
                contenuError.textContent = 'Le contenu de la question est requis.';
                isValid = false;
            }

            // Retourner false si une validation échoue
            return isValid;
        }
    </script>
</body>
</html>

