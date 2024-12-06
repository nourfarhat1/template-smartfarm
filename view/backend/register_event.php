<?php
require_once '../../config.php'; 
$iduser = 1; 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventId = $_GET['id'];

    $pdo = config::getConnexion();

    $stmtUserEvent = $pdo->prepare("INSERT INTO acceder_event (id_utilisateur, id_e) VALUES (?, ?)");

    $stmtUserEvent->bindParam(1, $iduser, PDO::PARAM_INT);
    $stmtUserEvent->bindParam(2, $eventId, PDO::PARAM_INT);

    if ($stmtUserEvent->execute()) {
        echo "L'événement a été ajouté et l'utilisateur a été associé avec succès !";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur à l'événement.";
    }
} else {
    echo "ID de l'événement invalide.";
}
?>
