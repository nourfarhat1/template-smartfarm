<?php
include(__DIR__ . '/../config/db.php');
include(__DIR__ . '/../models/Reponse.php');

class ReponseController
{
    private $db;

    // Constructor pour initialiser la connexion à la base de données
    public function __construct()
    {
        $this->db = Database::getConnexion(); // Connexion à la base de données
    }

    public function listReponses()
    {
        $sql = "SELECT * FROM reponse"; // Assurez-vous que le nom de la table est correct
        try {
            $list = $this->db->query($sql);
            return $list->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les réponses
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage(); // Affichage de l'erreur si une exception est lancée
        }
    }

    public function deleteReponse($id)
    {
        $sql = "DELETE FROM reponse WHERE id = :id"; // Assurez-vous que le nom de la table est correct
        $req = $this->db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute(); // Exécution de la requête
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage(); // Affichage de l'erreur si l'exécution échoue
        }
    }

    public function addAnswer($questionId, $response, $email)
    {
        // Ajout de la réponse dans la base de données
        $sql = "INSERT INTO reponse (question_id, contenu, email) VALUES (:question_id, :response, :email)"; // Nom de la table corrigé
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':question_id', $questionId);
        $stmt->bindParam(':response', $response);
        $stmt->bindParam(':email', $email);

        try {
            if ($stmt->execute()) {
                // La réponse est ajoutée avec succès
                return;
            } 
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage(); // Affichage de l'erreur
        }
    }

    public function updateReponse($reponse, $id)
    {
        try {
            $query = $this->db->prepare(
                'UPDATE reponse SET 
                    question_id = :question_id,
                    contenu = :contenu,
                    email = :email
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                'question_id' => $reponse->getQuestionId(),
                'contenu' => $reponse->getContenu(),
                'email' => $reponse->getEmail()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>"; // Retourner le nombre de mises à jour
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Affichage de l'erreur si la requête échoue
        }
    }

    public function showReponse($id)
    {
        $sql = "SELECT * FROM reponse WHERE id = :id"; // Assurez-vous que le nom de la table est correct
        try {
            $query = $this->db->prepare($sql);
            $query->execute(['id' => $id]);

            $reponse = $query->fetch(PDO::FETCH_ASSOC);  // Récupérer la réponse sous forme de tableau associatif
            return $reponse;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage(); // Affichage de l'erreur si la requête échoue
        }
    }
  public function likeAnswer($answerId) 
  //Cette ligne déclare la méthode likeAnswer qui prend un paramètre $answerId.
  {
        $query = "UPDATE reponse SET likes = likes + 1 WHERE id = :answerId";//Cette ligne définit la requête SQL qui met à jour-
        // le nombre de likes pour la réponse avec l'ID spécifié ($answerId).
        $stmt = $this->db->prepare($query);//Préparation de la requête
        $stmt->bindParam(':answerId', $answerId, PDO::PARAM_INT);//Cette ligne lie le paramètre $answerId à la requête préparée ($stmt).
        $stmt->execute();
    }

    public function dislikeAnswer($answerId) {
        $query = "UPDATE reponse SET dislikes = dislikes + 1 WHERE id = :answerId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':answerId', $answerId, PDO::PARAM_INT);
        $stmt->execute();
    }
   
}
?>
