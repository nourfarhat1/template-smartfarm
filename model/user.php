<?php

class User {
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $role; // agriculture, simple_user, livreur
    
    public function __construct($nom, $prenom, $email, $password, $role) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password =$password;// Password hashing
        $this->role = $role;
    }

    // Getters
    
    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRole() {
        return $this->role;
    }
}
    // Save user to the appropriate table based on the role
  /*  public function save() {
require_once __DIR__ . '/../../nour.php';
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Assign to the appropriate table based on role
        if ($this->definition == 'agriculture') {
            $sql = "INSERT INTO agriculture_users (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
        } elseif ($this->definition == 'livreur') {
            $sql = "INSERT INTO livreur_users (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
        } else { // default is simple_user
            $sql = "INSERT INTO simple_users (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
        }

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing the SQL statement: " . $conn->error);
        }
        $stmt->bind_param("ssss", $this->nom, $this->prenom, $this->email, $this->password);

        if ($stmt->execute()) {
            echo "User added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
*/

?>
