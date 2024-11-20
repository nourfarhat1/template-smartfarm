<?php

require_once './controller/event_controller.php';
require_once './config.php';

try {
    $db = config::getConnexion();
    $controller = new EventController($db);
    $controller->displayEvents();
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

?>
