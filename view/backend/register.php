//This form will allow the user to register. The password will be hashed for security.
<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing

    // SQL query to insert the new user
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);

    header("Location: login.php"); // Redirect after successful registration
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Register</title>
  <!-- Your other head elements -->
</head>
<body>
  <form method="POST" action="">
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Email" required>
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
</body>
</html>
