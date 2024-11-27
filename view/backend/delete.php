<?php
include_once(__DIR__ . '/../../controller/event_controller.php');

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $eventController = new EventController();

    $eventController->deleteEvent($eventId);

    echo "L'événement a été supprimé avec succès!";
    echo '
    <script>
        setTimeout(function() {
            window.location.href = "affichier_dashboard.php";
        }, 5000);
    </script>';
}
?>
