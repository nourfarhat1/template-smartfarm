<?php
include(__DIR__ . '/../config/db.php');  // Assurez-vous que ce fichier contient la classe Database
include(__DIR__ . '/../models/Question.php');

class QuestionController
{
    public function __construct() {
        // Créez une instance de la base de données
        $this->db = Database::getConnexion(); // Assurez-vous que vous avez une classe Database pour gérer la connexion DB
    }
    public function listQuestions($searchKeyword = '', $searchUsername = '', $searchEmail = '', $order = 'ASC') {//declarer la methode 
        // Requête SQL dynamique avec des conditions de recherche
        $query = "SELECT * FROM question WHERE 1=1"; // Commence avec une condition toujours vraie pour faciliter l'ajout de filtres 

        // Ajouter des conditions si des filtres sont appliqués
        if (!empty($searchKeyword)) {
            $query .= " AND contenu LIKE :searchKeyword";
        }
        if (!empty($searchUsername)) {
            $query .= " AND username LIKE :searchUsername";
        }
        if (!empty($searchEmail)) {
            $query .= " AND email LIKE :searchEmail";
        }

        // Ajouter la condition de tri par date
        $query .= " ORDER BY created_at " . $order;

        // Préparer et exécuter la requête
        $stmt = $this->db->prepare($query);

        // Lier les paramètres de recherche si nécessaires
        if (!empty($searchKeyword)) {
            $stmt->bindValue(':searchKeyword', '%' . $searchKeyword . '%');
        }
        if (!empty($searchUsername)) {
            $stmt->bindValue(':searchUsername', '%' . $searchUsername . '%');
        }
        if (!empty($searchEmail)) {
            $stmt->bindValue(':searchEmail', '%' . $searchEmail . '%');
        }

        // Exécution de la requête
        $stmt->execute();
        
        // Retourner toutes les questions filtrées
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function deleteQuestion($id)
    {
        $sql = "DELETE FROM question WHERE id = :id";
        $db = Database::getConnexion();  // Utilisez Database::getConnexion() et non config::getConnexion()
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addQuestion($question)
    {
        $sql = "INSERT INTO question (username, contenu, email) 
                VALUES (:username, :contenu, :email)";
        $db = Database::getConnexion();  // Utilisez Database::getConnexion() et non config::getConnexion()
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'username' => $question->getUsername(),
                'contenu' => $question->getContenu(),
                'email' => $question->getEmail()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateQuestion($question, $id)
    {
        try {
            $db = Database::getConnexion();  // Utilisez Database::getConnexion() et non config::getConnexion()

            $query = $db->prepare(
                'UPDATE question SET 
                    username = :username,
                    contenu = :contenu,
                    email = :email
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                'username' => $question->getUsername(),
                'contenu' => $question->getContenu(),
                'email' => $question->getEmail()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

 
        public function showQuestion($questionId) {
            $sql = "SELECT * FROM question WHERE id = :id"; // Assurez-vous que le nom de votre table est correct
            $db = Database::getConnexion();
        
            try {
                $query = $db->prepare($sql);
                $query->execute(['id' => $questionId]);
                $question = $query->fetch(PDO::FETCH_ASSOC); // Retourner la question en tant qu'array associatif
                return $question;
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }
        public function listAnswersByQuestionId($questionId) {
            $sql = "SELECT * FROM reponse WHERE question_id = :question_id";
            $db = Database::getConnexion();
            try {
                $query = $db->prepare($sql);
                $query->execute(['question_id' => $questionId]);
                return $query->fetchAll(PDO::FETCH_ASSOC); // Return answers as an array
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }
       
        public function getStatisticsByUser() {
            // Pas besoin de créer une instance de Question pour obtenir les statistiques
            $query = "SELECT username, COUNT(id) AS question_count FROM question GROUP BY username";
        
            // Utiliser $this->db directement pour exécuter la requête
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        
            // Récupérer les résultats
            $statistics = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $statistics;
        }
        
      

}
?>
