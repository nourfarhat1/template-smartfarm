<?php
class Question {
    private ?int $id;
    private ?string $username;
    private ?string $contenu;
    private ?string $email;

    // Constructor
    public function __construct(?int $id, ?string $username, ?string $contenu, ?string $email) {
        $this->id = $id;
        $this->username = $username;
        $this->contenu = $contenu;
        $this->email = $email;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(?string $username): void {
        $this->username = $username;
    }

    public function getContenu(): ?string {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): void {
        $this->contenu = $contenu;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }
}
?>
