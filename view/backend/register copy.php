<?php
// Include the User class
require_once __DIR__ . '/../../model/user.php';

// Database connection parameters
$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "testdata";  // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Create a new User object
    $user = new User($nom, $prenom, $email, $password, $role);

    // Store getter values in variables (if necessary)
    $nom = $user->getNom();
    $prenom = $user->getPrenom();
    $email = $user->getEmail();
    $password = $user->getPassword();
    $role = $user->getRole();

    // Debugging output (to check values)
    echo 'Name: ' . $nom . '<br>';
    echo 'Prenom: ' . $prenom . '<br>';
    echo 'Email: ' . $email . '<br>';
    echo 'role: ' . $role . '<br>';

    // Hash the password

    // Determine which SQL query to use based on the role
    if ($role == "agriculture") {
        $sql = "INSERT INTO agriculture_users (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
    } else if ($role == "simple_user") {
        $sql = "INSERT INTO simple_users (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
    } else if ($role == "livreur") {
        $sql = "INSERT INTO livreur_users (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
    } else {
        echo "<script>alert('Invalid user role!');</script>";
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind the parameters (assuming string format "ssss")
    $stmt->bind_param("ssss", $nom, $prenom, $email, $password);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect or display success message
        echo "<script>alert('User has been added successfully!'); window.location.href = 'http://localhost/crud/smartfarmproduit2.8/view/frontend/NASSIMlogin.html';</script>";
    } else {
        // Handle errors if insertion fails
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
