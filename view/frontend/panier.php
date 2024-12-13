<?php
session_start();

// Inclure le fichier de configuration pour la base de données
require_once 'C:/xampp/htdocs/test solo/config.php';

// Initialiser le panier si ce n'est pas déjà fait
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Calculer le total du panier
function calculerTotalPanier($panier)
{
    $total = 0;
    foreach ($panier as $produit) {
        $total += $produit['prix'] * $produit['quantitepan'];
    }
    return $total;
}

$total = calculerTotalPanier($_SESSION['panier']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="panier.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .mute-button {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background-color: #f0f0f0;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <audio id="background-music" autoplay loop>
        <source src="music.mp3" type="audio/mpeg">
        Votre navigateur ne supporte pas l'élément audio.
    </audio>
    <button id="mute-button" class="mute-button">🔊 Mute</button>

    <div class="container">
        <h1>Votre Panier</h1>
        <div id="panier-container">
            <?php include 'ajax_panier_content.php'; ?>
        </div>
        <div id="actions-container">
            <button id="enregistrer-panier">Enregistrer le panier</button>
            <button id="historique-panier">Voir l'historique des paniers</button>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Mon Site</p>
    </footer>

    <script>
    $(document).ready(function () {
        // Gestion du bouton mute
        const audio = document.getElementById('background-music');
        const muteButton = document.getElementById('mute-button');

        muteButton.addEventListener('click', () => {
            if (audio.muted) {
                audio.muted = false;
                muteButton.textContent = '🔊 Mute';
            } else {
                audio.muted = true;
                muteButton.textContent = '🔇 Unmute';
            }
        });

        // Mise à jour du panier via AJAX
        function updatePanier() {
            $.get('ajax_panier.php', function (data) {
                $('#panier-container').html(data.html);
            }, 'json');
        }

        // Gestion des boutons "+" et "-"
        $(document).on('click', '.increment, .decrement, .supprimer', function () {
            const action = $(this).hasClass('increment') ? 'increment' :
                $(this).hasClass('decrement') ? 'decrement' : 'supprimer';
            const idproduit = $(this).data('idproduit');

            $.post('ajax_panier.php', { action, idproduit }, function (data) {
                $('#panier-container').html(data.html);
                $('#actions-container').show(); // Assurez que les boutons restent visibles
            }, 'json');
        });

        // Enregistrer le panier
        $('#enregistrer-panier').on('click', function () {
            $.post('ajax_panier.php', { action: 'enregistrer_panier' }, function (data) {
                if (data.success) {
                    alert(data.message);
                    updatePanier();
                } else {
                    alert("Erreur : " + data.message);
                }
            }, 'json');
        });

        // Voir l'historique des paniers
        $('#historique-panier').on('click', function () {
            window.location.href = 'historique_panier.php';
        });
    });
</script>

</body>

</html>
