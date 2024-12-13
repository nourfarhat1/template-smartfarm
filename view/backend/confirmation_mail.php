<?php
session_start();

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assure-toi que PHPMailer est bien installé via Composer

// Vérifier si l'ID du panier est présent
if (!isset($_GET['idpanier'])) {
    die("ID du panier non spécifié.");
}

$idpanier = $_GET['idpanier'];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Vérifier si l'email est valide
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Initialiser PHPMailer
            $mail = new PHPMailer(true);

            // Paramètres SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; // Remplace par ton serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@example.com'; // Ton adresse e-mail
            $mail->Password = 'your-email-password'; // Ton mot de passe SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Expéditeur et destinataire
            $mail->setFrom('your-email@example.com', 'Nom du Site');
            $mail->addAddress($email);

            // Contenu de l'e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre commande';
            $mail->Body    = "<p>Merci pour votre commande ! Votre ID de panier est : $idpanier.</p>";

            // Envoyer l'e-mail
            $mail->send();

            echo "<p>Un e-mail de confirmation a été envoyé à $email.</p>";
            header("Location: produit.php?status=email_sent");
            exit();
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('L\'adresse e-mail est invalide.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de l'adresse e-mail</title>
</head>
<body>
    <h1>Confirmer votre adresse e-mail</h1>
    <p>ID du Panier : <strong><?php echo htmlspecialchars($idpanier); ?></strong></p>
    <form method="POST">
        <label for="email">Adresse e-mail :</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Confirmer l'adresse</button>
    </form>
</body>
</html>
