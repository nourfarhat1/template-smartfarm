<?php
// app/views/Backoffice/allQuestions.php
include_once __DIR__ . '/../../controllers/QuestionController.php'; // Inclure le contrôleur
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialiser le contrôleur
$controller = new QuestionController();

// Récupérer l'ordre de tri depuis l'URL (si disponible)
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$questions = $controller->listQuestions('', '', '', $order); // Passer l'ordre de tri dans la fonction
$statistics = $controller->getStatisticsByUser();

// Connexion à la base de données
$host = 'localhost'; 
$dbname = 'smartfarm'; 
$username = 'root'; 
$password = ''; 

$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer l'utilisateur ayant posé le plus grand nombre de questions
$query = "SELECT username, email, COUNT(*) AS question_count
          FROM question
          GROUP BY username, email
          ORDER BY question_count DESC
          LIMIT 1";

// Exécuter la requête pour obtenir les résultats
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $email = $row['email'];

    // Utilisation de PHPMailer pour envoyer l'email
    require __DIR__ . '/../../../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ahmedzekri20666202@gmail.com'; // Remplacez par votre email
        $mail->Password = 'dogb xpjd levs jwka'; // Remplacez par votre mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Désactivation de la vérification SSL pour les tests locaux (en cas d'erreur SSL)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Debug pour mieux comprendre les erreurs SMTP
        $mail->SMTPDebug = 0; 
        $mail->Debugoutput = 'html';

        // Expéditeur et destinataire
        $mail->setFrom('ahmedzekri20666202@gmail.com', 'Ahmed');
        $mail->addAddress($email, $username);

        // Sujet et corps du message
        $mail->Subject = "Felicitations pour votre participation active!";
        $mail->isHTML(true);
        $mail->Body = "
        <html>
        <head>
            <title>Felicitations</title>
        </head>
        <body>
            <p>Bonjour $username,</p>
            <p>Nous vous félicitons pour avoir posé le plus grand nombre de questions sur SmartFarm.</p>
            <p>Nous vous encourageons à continuer de participer activement à notre plateforme.</p>
            <p>Merci de votre engagement!</p>
            <p>Cordialement,</p>
            <p>L'équipe SmartFarm</p>
        </body>
        </html>
        ";

        // Envoi de l'email
        $mail->send();
        echo "E-mail envoyé avec succès à $email.";
    } catch (Exception $e) {
        echo "Message non envoyé. Erreur: {$mail->ErrorInfo}";
    }
} else {
    echo "Aucun utilisateur trouvé.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Questions - SmartFarm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .questions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .questions-table th, .questions-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .questions-table th {
            background-color: #4CAF50;
            color: white;
        }
        .action-btn {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
        .action-btn.edit { background-color: #4CAF50; }
        .action-btn.delete { background-color: #f44336; }
        .action-btn.reply { background-color: #2196F3; }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .sort-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }
        .sort-btn:hover {
            background-color: #45a049;
        }
        #userChart {
            display: block;
            margin: 20px auto; /* Centrer le graphique */
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>Bienvenue sur SmartFarm</h1>
        <nav>
            <ul>
                <li><a href="http://localhost:5500/">Accueil</a></li>
                <li><a href="addQuestion.php">Ajouter une Question</a></li>
                <li><a href="answerQuestionForm.php">Répondre aux Questions</a></li>
                <li><a href="about.php">À Propos</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Liste des Questions</h1>
        <form method="GET" action="">
            <button type="submit" name="order" value="asc" class="sort-btn">Trier par date (Croissant)</button>
            <button type="submit" name="order" value="desc" class="sort-btn">Trier par date (Décroissant)</button>
        </form>
        <table class="questions-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Contenu</th>
                    <th>Date d'Ajout</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?= $question['id'] ?></td>
                        <td><?= $question['username'] ?></td>
                        <td><?= $question['email'] ?></td>
                        <td><?= $question['contenu'] ?></td>
                        <td><?= $question['created_at'] ?></td>
                        <td>
                            <a href="edit_question.php?id=<?= $question['id'] ?>" class="action-btn edit">Modifier</a> |
                            <a href="delete_question.php?id=<?= $question['id'] ?>" class="action-btn delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">Supprimer</a> |
                            <a href="answerQuestionForm.php?question_id=<?= $question['id'] ?>" class="action-btn reply">Répondre</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Statistiques des questions par utilisateur</h2>
        <canvas id="userChart" width="300" height="300"></canvas>
        <script>
            const statistics = <?= json_encode($statistics) ?>;
            const usernames = statistics.map(stat => stat.username);
            const questionCounts = statistics.map(stat => stat.question_count);

            new Chart(document.getElementById('userChart'), {
                type: 'pie',
                data: {
                    labels: usernames,
                    datasets: [{
                        data: questionCounts,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 14 } }
                        }
                    }
                }
            });
        </script>
    </div>

    <footer>
        <p>&copy; 2024 SmartFarm | Tous droits réservés</p>
    </footer>
</body>
</html>
