<?php
require_once __DIR__ . '/Reclamation.php';  // No need to go up a level

class Reclamation
{
    private ?string $Nom;
    private ?string $Email;
    private ?string $Subject;
    private ?string $Message;

    // Constructor
    public function __construct(
        ?string $Nom = null,
        ?string $Email = null,
        ?string $Subject = null,
        ?string $Message = null
    ) {
        $this->Nom = $Nom;
        $this->Email = $Email;
        $this->Subject = $Subject;
        $this->Message = $Message;
    }

    // Getters and Setters
    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): void
    {
        $this->Nom = $Nom;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): void
    {
        $this->Email = $Email;
    }

    public function getSubject(): ?string
    {
        return $this->Subject;
    }

    public function setSubject(?string $Subject): void
    {
        $this->Subject = $Subject;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(?string $Message): void
    {
        $this->Message = $Message;
    }
}

?>