<?php
// Inclure les fichiers nécessaires
include_once __DIR__ . '/../../controllers/QuestionController.php';
include_once __DIR__ . '/../../controllers/ReponseController.php';

$controller = new QuestionController();
$controllerrep = new ReponseController();


// Récupérer les paramètres de recherche (si présents)
$searchKeyword = isset($_GET['searchKeyword']) ? $_GET['searchKeyword'] : '';
$searchUsername = isset($_GET['searchUsername']) ? $_GET['searchUsername'] : '';
$searchEmail = isset($_GET['searchEmail']) ? $_GET['searchEmail'] : '';

// Passer les paramètres de recherche à la fonction listQuestions
$questions = $controller->listQuestions($searchKeyword, $searchUsername, $searchEmail);
// Traiter les actions de like et dislike
// Vérification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['answer_id'])) {
        // Récupération de l'ID de la réponse et de l'action (like ou dislike)
        $answerId = $_POST['answer_id'];
        $action = $_POST['action'];

        // Si l'action est "like", incrémenter les likes
        if ($action === 'like') {
            $controllerrep->likeAnswer($answerId);
        }

        // Si l'action est "dislike", incrémenter les dislikes
        elseif ($action === 'dislike') {
            $controllerrep->dislikeAnswer($answerId);
        }

        // Rediriger après le traitement pour éviter les soumissions multiples
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil - SmartFarm</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Styles pour la liste des questions */
        .questions-section {
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
        }

        .questions-section h2 {
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .question-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .question-card:hover {
            transform: scale(1.02);
        }

        .question-card h3 {
            font-size: 1.2em;
            margin: 0 0 10px;
        }

        .question-card p {
            font-size: 0.9em;
            color: #555;
        }

        .question-card small {
            display: block;
            margin-top: 10px;
            font-size: 0.8em;
            color: #999;
        }

        .question-card .btn-container {
            align-self: flex-end; /* Aligne le bouton à droite */
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50; /* Couleur verte */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-repondre {
            background-color: #28a745; /* Couleur verte plus claire */
        }

        .btn-repondre:hover {
            background-color: #218838; /* Couleur verte plus foncée */
        }

        /* Styles pour les réponses */
        .reponse-card {
            margin-top: 10px;
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .reponse-card p {
            font-size: 0.9em;
            color: #333;
        }

        .reponse-card small {
            font-size: 0.8em;
            color: #777;
        }

        /* Styles pour la barre de recherche */
        .search-form {
    margin-bottom: 20px;
    text-align: center;
    display: flex; /* Utilisation de Flexbox pour aligner l'input et les boutons sur la même ligne */
    justify-content: center;
    align-items: center; /* Centrer verticalement les éléments */
}

.search-form input {
    padding: 8px;
    margin-right: 5px;
    font-size: 1em;
    width: 200px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.search-form button,
.search-form .btn-reset { /* Application des mêmes styles pour les deux boutons */
    padding: 6px 15px; /* Taille de l'intérieur du bouton */
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em; /* Taille de la police égale pour les deux boutons */
    width: auto; /* Laisser les boutons ajuster leur taille automatiquement */
    min-width: 120px; /* Largeur minimale pour les deux boutons */
    height: 36px; /* Même hauteur pour les deux boutons */
    margin-left: 5px; /* Un petit espacement entre les boutons */
}

.search-form button:hover,
.search-form .btn-reset:hover {
    background-color: #45a049; /* Changement de couleur au survol */
}

.search-form .btn-reset {
    background-color: #f44336; /* Couleur rouge pour le bouton "Réinitialiser" */
}

.search-form .btn-reset:hover {
    background-color: #e53935; /* Rouge plus foncé au survol pour le bouton "Réinitialiser" */
}

        

.btn-like {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.like-container {
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Aligner le cœur à droite */
}



.like-count {
    margin-left: 10px;
    font-size: 1em; /* Taille du texte */
}

.search-form .btn-reset {
    background-color: #f44336; /* Couleur rouge pour le bouton "Réinitialiser" */
}

.search-form .btn-reset:hover {
    background-color: #e53935; /* Couleur rouge plus foncée au survol */
}

    </style>
</head>
<body>
    <!-- Section d'En-tête -->
    <header>
        <div class="container">
            <h1>Bienvenue sur SmartFarm</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="app/views/Backoffice/allQuestions.php">Questions</a></li>
                    <li><a href="app/views/Backoffice/list.php">Réponses</a></li>
                    <li><a href="about.php">À Propos</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Section Principale -->
    <main>
        <section class="welcome-section">
            <h2>Bienvenue sur votre plateforme de gestion de Questions et Réponses</h2>
            <p>Voici la page d'accueil de SmartFarm, où vous pouvez consulter, ajouter et répondre aux questions.</p>
            <a href="app/views/Frontoffice/addQuestion.php" class="btn">Soumettre des Questions</a>
        </section>

        <!-- Formulaire de Recherche -->
        <section class="search-section">
            <form class="search-form" method="GET" action="index.php">
                <input type="text" name="searchKeyword" placeholder="Rechercher par contenu" value="<?= htmlspecialchars($searchKeyword); ?>">
                <input type="text" name="searchUsername" placeholder="Rechercher par nom d'utilisateur" value="<?= htmlspecialchars($searchUsername); ?>">
                <input type="email" name="searchEmail" placeholder="Rechercher par email" value="<?= htmlspecialchars($searchEmail); ?>">
                <button type="submit">Rechercher</button>
                <a href="index.php" class="btn btn-reset">Réinitialiser</a> <!-- Bouton Réinitialiser -->

            </form>
        </section>

        <!-- Section Liste des Questions -->
        <section class="questions-section">
            <h2>Liste des Questions</h2>
            <?php if (!empty($questions)) : ?>
                <?php foreach ($questions as $question) : ?>
                    <div class="question-card">
                        <h3><?= htmlspecialchars($question['username']); ?></h3>
                        <p><?= htmlspecialchars($question['contenu']); ?></p>
                        <small>Email: <?= htmlspecialchars($question['email']); ?></small>
                        <div class="btn-container">
                            <!-- Bouton "Répondre" avec chemin corrigé -->
                            <a href="./app/views/Frontoffice/answerQuestionForm.php?question_id=<?= htmlspecialchars($question['id']); ?>" class="btn btn-repondre">Répondre</a>
                        <a href="./app/views/Frontoffice/delete_question.php?id=<?= htmlspecialchars($question['id']); ?>" class="btn btn-supprimera">Supprimer</a>
                        <a href="./app/views/Frontoffice/edit_question.php?id=<?= htmlspecialchars($question['id']); ?>" class="btn btn-modifiera">Modifier</a>
                        </div>

                        <!-- Affichage des réponses -->
                        <!-- Affichage des réponses -->
<?php
$answers = $controller->listAnswersByQuestionId($question['id']);
if (!empty($answers)) :
    foreach ($answers as $answer) : ?>
        <div class="reponse-card">
            <p><?= htmlspecialchars($answer['contenu']); ?></p>
            <a class='action-btn delete' href='./app/views/Frontoffice/deleteReponse.php?id=<?= htmlspecialchars($answer['id']); ?>'>Supprimer</a>
            <a class='action-btn edit' href='./app/views/Frontoffice/editAnswerForm.php?id=<?= htmlspecialchars($answer['id']); ?>'>Modifier</a>
<div class="like-container">
<div class="like-container">
    <form method="POST" action="">
        <!-- ID de la réponse envoyée -->
        <input type="hidden" name="answer_id" value="<?= htmlspecialchars($answer['id']); ?>">
        
        <!-- Bouton Like -->
        <button type="submit" name="action" value="like" class="btn-like">👍</button>
        <span class="like-count"><?= htmlspecialchars($answer['likes']); ?></span>

        <!-- Bouton Dislike -->
        <button type="submit" name="action" value="dislike" class="btn-like">👎</button>
        <span class="like-count"><?= htmlspecialchars($answer['dislikes']); ?></span>
    </form>
</div>

        </div>
    <?php endforeach; ?>

    <?php  else : ?>
                            <p>Aucune réponse à cette question pour le moment.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucune question n'a été ajoutée pour le moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Section Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 SmartFarm. Tous droits réservés.</p>
        </div>
    </footer>
    
</body>
</html>

