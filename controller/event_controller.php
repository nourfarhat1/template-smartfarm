<?php

require_once __DIR__ . '/../model/event_model.php'; //t3ayet llfichier une seule fois 
//require __DIR__ . '../../view/Backend/afficher_event.php';

class EventController { //nhotou feha plusieurs fcts ou hiya tcontrolihom
    private $eventModel;//model privée juste ymchi al fichier hedha khw fih tous les évenements 

    public function __construct($db) {//fct bch ne5dhou model event min bd mteena
        $this->eventModel = new EventModel($db);
    }

    public function displayEvents() {
        $events = $this->eventModel->getAllEvents();//bch yaaytlhom lkol 
        require __DIR__ . '/../view/Backend/afficher_event.php';//yab3ith les event fil  fichier lkol plusieurs fois 
        
    }
    
}

?>