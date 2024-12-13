This page will allow a logged-in user to update their email or password.
<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user_id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash new password

    // SQL query to update user info
    $sql = "UPDATE users SET email = :email, password = :password WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password, 'id' => $id]);

    header("Location: dashboard.php"); // Redirect after updating
    exit();
}

// Fetch current user details
$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Update Profile</title>
  <!-- Your other head elements -->
</head>
<body>
  <form method="POST" action="">
    <label for="email">Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <label for="password">Password</label>
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Update</button>
  </form>
</body>
</html>
