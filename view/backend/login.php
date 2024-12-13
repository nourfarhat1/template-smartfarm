<?php
session_start(); // Start the session to store user data after login

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
    $email = $_POST['email'];
    $password = $_POST['password'];  // Plain password entered by the user

    // Search for the user in the database based on email
    $sql = "SELECT * FROM agriculture_users WHERE email = ? UNION 
            SELECT * FROM simple_users WHERE email = ? UNION
            SELECT * FROM livreur_users WHERE email = ?"; // Query all 3 user types
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $email, $email);  // Bind email for each table

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password using password_verify
        if ($password==$user['password']) {  // $user['password'] is the hashed password stored in the database
            // Successful login
            $_SESSION['user_id'] = $user['id'];  // Save user ID in session
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];  // Save user role (Agriculture, Simple, Livreur)
            
            // Redirect to user dashboard or home page
            echo "<script>alert('Login successful!'); window.location.href =  'http://localhost/crud/smartfarmproduit2.8/view/frontend/profile.php';</script>";
        } else {
            // Incorrect password
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        // User does not exist
        echo "<script>alert('No account found with that email address.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
