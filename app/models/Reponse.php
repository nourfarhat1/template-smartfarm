<?php
class Reponse {
    private ?int $id;
    private ?int $question_id;
    private ?string $contenu;
    private ?string $email;
   // private int $likes;  // Ajout du champ likes

    // Constructor
    public function __construct(?int $id, ?int $question_id, ?string $contenu, ?string $email ) {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->contenu = $contenu;
        $this->email = $email;
       // $this->likes = $likes;  // Initialisation du champ likes
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getQuestionId(): ?int {
        return $this->question_id;
    }

    public function setQuestionId(?int $question_id): void {
        $this->question_id = $question_id;
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

    
    public static function findById($db, $id)
    {
        $sql = "SELECT * FROM reponse WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new self($data['id'], $data['question_id'], $data['contenu'], $data['email'], $data['likes']);
        }
        return null; // Si la réponse n'existe pas
    }
}
?>
