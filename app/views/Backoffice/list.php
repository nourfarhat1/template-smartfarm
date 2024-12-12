<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Questions - SmartFarm</title>
    <style>
        /* Style général du corps de la page */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eef2f3;
            color: #333;
        }

        /* En-tête */
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header .container {
            width: 90%;
            margin: 0 auto;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        header h2 {
            margin-top: 10px;
            font-size: 1.5rem;
            font-weight: normal;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav ul li a {
    color: #4CAF50; /* Changer la couleur du texte en vert */
    text-decoration: none;
    font-size: 1.1rem;
    padding: 5px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
}


        /* Conteneur principal */
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Style du tableau */
        .questions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .questions-table th,
        .questions-table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .questions-table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .questions-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .questions-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Style des liens d'action */
        .action-btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 0.9rem;
            display: inline-block;
            margin: 2px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .action-btn.edit {
            background-color: #4CAF50;
            color: white;
        }

        .action-btn.edit:hover {
            background-color: #4CAF50;
            transform: scale(1.05);
        }

        .action-btn.delete {
            background-color: #f44336;
            color: white;
        }

        .action-btn.delete:hover {
            background-color: #e53935;
            transform: scale(1.05);
        }

        .action-btn.reply {
            background-color: #2196F3;
            color: white;
        }

        .action-btn.reply:hover {
            background-color: #1976D2;
            transform: scale(1.05);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            margin-top: 30px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Section d'En-tête -->
    <header>
        <div class="container">
            <h1>Bienvenue sur SmartFarm</h1>
            <h2>Liste des Questions</h2>
            <nav>
                <ul>
                <li><a href="http://localhost:5500/">Accueil</a></li>
                    <li><a href="app/views/backOffice/addQuestion.php">Ajouter une Question</a></li>
                    <li><a href="app/views/backOffice/answerQuestionForm.php">Répondre aux Questions</a></li>
                    <li><a href="about.php">À Propos</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <?php
        // Include the database connection
        include_once 'C:/xampp/htdocs/projet23/projet/app/config/db.php';

        // Get the database connection
        $conn = Database::getConnexion();  // Assuming you're using a static method like this

        // Prepare and execute the query to fetch all responses
        $sql = "SELECT * FROM reponse";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Check if the query returned any rows
        if ($stmt->rowCount() > 0) {
            // Display the responses
            echo "<h1>Liste des Réponses</h1>";
            echo "<table class='questions-table'>
                    <tr>
                        <th>ID</th>
                        <th>ID Question</th>
                        <th>Contenu</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>";

            // Fetch all results and display them in a table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['question_id']) . "</td>
                        <td>" . htmlspecialchars($row['contenu']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>
                            <a class='action-btn delete' href='deleteReponse.php?id=" . urlencode($row['id']) . "'>Supprimer</a>
                            <a class='action-btn edit' href='editAnswerForm.php?id=" . urlencode($row['id']) . "'>Modifier</a>
                        </td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Aucune réponse trouvée.</p>";
        }

        // Close the statement and the connection (for PDO)
        $stmt = null;  // Close the statement
        $conn = null;  // Close the connection
        ?>
    </div>
    <footer>
        <p>&copy; 2024 SmartFarm | Tous droits réservés</p>
    </footer>
</body>
</html>
