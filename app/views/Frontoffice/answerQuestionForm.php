<?php
include_once __DIR__ . '/../../controllers/QuestionController.php';

// Vérifier que l'ID de la question est passé dans l'URL
if (isset($_GET['question_id'])) {
    $questionId = $_GET['question_id'];

    // Instancier le contrôleur et récupérer les informations de la question
    $controller = new QuestionController();
    $question = $controller->showQuestion($questionId); // Récupérer la question avec son ID
}

session_start();

// Vérifier si l'utilisateur est connecté et récupérer son email
$email = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Récupérer l'email de la session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Répondre à une Question</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Styles personnalisés */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            resize: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }

        .info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Répondre à une Question</h1>
    <div class="container">
        <?php if ($question) : ?>
            <div class="info">
                <p><strong>Utilisateur :</strong> <?= htmlspecialchars($question['username']); ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($question['email']); ?></p>
            </div>
            <form id="responseForm" method="POST">
                <div class="form-group">
                    <label for="email">Votre Email :</label>
                    <input type="email" name="email" id="email" placeholder="Entrez votre email" >
                    <small id="emailError" class="error" style="display: none;">Veuillez entrer un email valide.</small>
                </div>
                <div class="form-group">
                    <textarea name="response" id="response" placeholder="Votre réponse ici..." ></textarea>
                    <small id="responseError" class="error" style="display: none;">La réponse ne peut pas être vide.</small>
                </div>
                <input type="hidden" name="question_id" id="question_id" value="<?= htmlspecialchars($question['id']); ?>">
                <button type="submit">Envoyer la Réponse</button>
            </form>

            <div id="message"></div>
        <?php else : ?>
            <p class="error">La question est introuvable ou l'identifiant est manquant.</p>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('responseForm').addEventListener('submit', function(e) {
            e.preventDefault();  // Empêcher le rechargement de la page

            var email = document.getElementById('email').value;
            var response = document.getElementById('response').value;
            var emailError = document.getElementById('emailError');
            var responseError = document.getElementById('responseError');

            // Réinitialiser les messages d'erreur
            emailError.style.display = 'none';
            responseError.style.display = 'none';

            var valid = true;

            // Validation de l'email
            if (!validateEmail(email)) {
                emailError.style.display = 'inline';
                valid = false;
            }

            // Validation de la réponse
            if (response.trim() === '') {
                responseError.style.display = 'inline';
                valid = false;
            }

            // Si la validation échoue, ne pas envoyer le formulaire
            if (!valid) {
                return;
            }

            // Si tout est valide, envoyer la réponse via AJAX
            var formData = new FormData(this);  // Récupérer les données du formulaire

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'submitAnswer.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Afficher le message de succès ou d'erreur
                    document.getElementById('message').innerHTML = xhr.responseText;

                    // Après avoir répondu, rediriger vers la page précédente et rafraîchir la page
                    setTimeout(function() {
                        window.history.back(); // Redirige vers la page précédente
                    }, 2000); // Attendre 2 secondes pour voir le message
                }
            };

            xhr.send(formData);  // Envoyer les données
        });

        // Fonction de validation de l'email
        function validateEmail(email) {
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailRegex.test(email);
        }
    </script>
</body>
</html>
