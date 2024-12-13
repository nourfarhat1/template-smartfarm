<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdata";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch existing user data
$sql = "SELECT * FROM agriculture_users WHERE id = ? UNION 
        SELECT * FROM simple_users WHERE id = ? UNION 
        SELECT * FROM livreur_users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Profile Image Upload
if ($_FILES['profile_image']['name']) {
    $image_name = $_FILES['profile_image']['name'];
    $image_tmp = $_FILES['profile_image']['tmp_name'];
    $image_path = "uploads/" . $image_name;  // Path to save image
    move_uploaded_file($image_tmp, $image_path);
} else {
    $image_path = $user['profile_image'];  // Keep current image if no new image uploaded
}

// Password Update (if provided)
$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

// Update the profile in the database
$sql = "UPDATE agriculture_users SET nom = ?, prenom = ?, email = ?, profile_image = ?, password = ? WHERE id = ? 
        UNION 
        UPDATE simple_users SET nom = ?, prenom = ?, email = ?, profile_image = ?, password = ? WHERE id = ? 
        UNION 
        UPDATE livreur_users SET nom = ?, prenom = ?, email =
