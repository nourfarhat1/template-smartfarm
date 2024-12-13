<?php
require_once __DIR__ . '/../../model/reclamation.php';  // Adjusted path

$servername = "localhost";  // Adjust these parameters to your database
$username = "root";
$password = "";
$dbname = "testdata";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Create a Reclamation object
    $reclamation = new Reclamation($name, $email, $subject, $message);

    // Store getter values in variables
    $nom = $reclamation->getNom();
    $email = $reclamation->getEmail();
    $subject = $reclamation->getSubject();
    $message = $reclamation->getMessage();

    // Check the values being passed into the prepared statement
    echo 'Name: ' . $nom . '<br>';
    echo 'Email: ' . $email . '<br>';
    echo 'Subject: ' . $subject . '<br>';
    echo 'Message: ' . $message . '<br>';

    // Insert into the database
    $sql = "INSERT INTO reclamation (Nom, Email, Subject, Message) VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Error preparing the statement: ' . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ssss", $nom, $email, $subject, $message);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect or display success message
        echo "<script>alert('Your reclamation has been added successfully!'); window.location.href = 'http://localhost/crud/smartfarmproduit2.8/view/backend/dashboard.php';</script>";
    } else {           
        

        // Handle errors if insertion fails
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

