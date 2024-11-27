<?php

class Event {

    private ?int $id_e;
    private ?string $nom;
    private ?string $disc;
    private ?string $date;

    public function __construct(?int $id_e = null, ?string $nom = null, ?string $disc = null, ?string $date = null) {
        $this->id_e = $id_e;
        $this->nom = $nom;
        $this->disc = $disc;
        $this->date = $date;
    }
    
    public function getId(): ?int {
        return $this->id_e;
    }
    
    public function getNom(): ?string {
        return $this->nom;
    }
    
    public function getDisc(): ?string {
        return $this->disc;
    }
    
    public function getDate(): ?string {
        return $this->date;
    }
    
    public function setId(?int $id_e): void {
        $this->id_e = $id_e;
    }
    
    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }
    
    public function setDisc(?string $disc): void {
        $this->disc = $disc;
    }
    
    public function setDate(?string $date): void {
        $this->date = $date;
    }
}

class EventModel {
    private $db;

    public function __construct() {
        $this->db = config::getConnexion(); 
    }

    public function addEvent($nom, $disc, $date) {
        $sql = "INSERT INTO event (nom, disc, date) VALUES (:nom, :disc, :date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nom, ':disc' => $disc, ':date' => $date]);
    }

    public function updateEvent($id_e, $nom, $disc, $date) {
        $sql = "UPDATE event SET nom = :nom, disc = :disc, date = :date WHERE id_e = :id_e";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nom, ':disc' => $disc, ':date' => $date, ':id_e' => $id_e]);
    }

    public function deleteEvent($id_e) {
        $sql = "DELETE FROM event WHERE id_e = :id_e";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_e' => $id_e]);
    }

    public function getAllEvents() {
        $sql = "SELECT * FROM event";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getEventById($id_e) {
        $sql = "SELECT * FROM event WHERE id_e = :id_e";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_e' => $id_e]);
        return $stmt->fetch();
    }

    
}

?>
