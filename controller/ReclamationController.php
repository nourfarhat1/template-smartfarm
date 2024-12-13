<?php
require_once __DIR__ . '/../../nour.php';
include __DIR__ . '/../../model/Reclamation.php';

class ReclamationController
{   
    // CREATE: Add a new category
    public function addReclamation($reclamation)
    {
        $sql = "INSERT INTO reclamation (nomreclamation) VALUES (:nomreclamation)";
        $nour = nour::getConnexion();
        
        try {
            $query = $nour->prepare($sql);
            $query->execute([
                'nomreclamation' => $category->getNom()
            ]);
            echo "reclamation added successfully!";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }



    public function create($conn)
    {
        $query = "INSERT INTO reclamations (Id_User, Nom, Email, Subject, Message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issss", $this->Id_User, $this->Nom, $this->Email, $this->Subject, $this->Message);
        return $stmt->execute();
    }

    // Read: Retrieve reclamation details by ID
    public function read($conn, $id)
    {
        $query = "SELECT * FROM reclamations WHERE Id_User = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update: Update reclamation details by ID
    public function update($conn)
    {
        $query = "UPDATE reclamations SET Nom = ?, Email = ?, Subject = ?, Message = ? WHERE Id_User = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $this->Nom, $this->Email, $this->Subject, $this->Message, $this->Id_User);
        return $stmt->execute();
    }

    // Delete: Delete a reclamation by ID
    public function delete($conn)
    {
        $query = "DELETE FROM reclamations WHERE Id_User = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $this->Id_User);
        return $stmt->execute();
    }
}