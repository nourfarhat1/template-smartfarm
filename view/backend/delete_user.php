<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_SESSION['user_id'];

    // SQL query to delete user from the database
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    // Destroy the session to log out the user
    session_destroy();

    header("Location: login.php"); // Redirect after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Delete Account</title>
  <!-- Your other head elements -->
</head>
<body>
  <p>Are you sure you want to delete your account?</p>
  <a href="delete_user.php?delete=true">Yes, delete my account</a>
  <a href="dashboard.php">No, go back to dashboard</a>
</body>
</html>
