<?php
include_once(__DIR__ . '/../../controller/event_controller.php');

$eventController = new EventController();

$eventController->showAllEvents();
?>
