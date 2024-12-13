<?php
require_once 'C:\xampp\htdocs\smartfarmproduit2.8\nour.php';
include(__DIR__ . '/../model/user.php');
class UserController
{
    // CREATE: Add a new category
    public function adduser($user)
    {
        $sql = "INSERT INTO user (id_useer) VALUES (:id_user)";
        $nour = nour::getConnexion();
        
        try {
            $query = $nour->prepare($sql);
            $query->execute([
                'id_user' => $category->getid_user()
            ]);
            echo "reclamation added successfully!";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>

