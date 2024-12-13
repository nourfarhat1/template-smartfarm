<?php
// Database connection
$host = "localhost"; // Change if needed
$dbname = "smartf"; // Using the database from the second code
$username = "root"; // Change if needed
$password = ""; // Change if needed

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$prenom = $nom = $email = $password = $role = $verification_code = "";
$errorMessage = $successMessage = $verificationMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Step 1: Handle the sign-up form submission
    if (isset($_POST["signup"])) {
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        do {
            if (empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($role)) {
                $errorMessage = "All fields are required.";
                break;
            }

            // Check if email already exists
            $checkStmt = $connection->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();
            $emailExists = $checkStmt->fetchColumn();

            if ($emailExists) {
                $errorMessage = "Email already registered. Please use a different email.";
                break;
            }

            // Generate a verification code
            $verification_code = rand(100000, 999999); // Random 6-digit code

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert data into the database with the verification code
            $sql = "INSERT INTO users (prenom, nom, email, password, role, verification_code, is_verified) 
                    VALUES (:prenom, :nom, :email, :password, :role, :verification_code, 0)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':verification_code', $verification_code);

            try {
                $stmt->execute();
                $successMessage = "Account successfully created. A verification code has been sent to your email.";

                // Step 2: Send the verification code via email
                $subject = "Email Verification Code";
                $message = "Hello $prenom,\n\nYour verification code is: $verification_code\n\nPlease enter this code to verify your email.\n\nThank you!";
                $headers = "From: noreply@example.com";
                mail($email, $subject, $message, $headers);

                // Clear fields after successful insert
                $prenom = $nom = $email = $password = $role = "";
            } catch (PDOException $e) {
                $errorMessage = "Error inserting data: " . $e->getMessage();
            }
        } while (false);
    }

    // Step 3: Handle the verification code submission
    if (isset($_POST["verify"])) {
        $email = $_POST["email"];
        $entered_code = $_POST["code"];

        // Check if the verification code matches
        $sql = "SELECT verification_code FROM users WHERE email = :email";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result && $result['verification_code'] == $entered_code) {
            // Update the user's verification status to true
            $updateSQL = "UPDATE users SET is_verified = 1 WHERE email = :email";
            $updateStmt = $connection->prepare($updateSQL);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();

            $verificationMessage = "Your email has been verified successfully!";
        } else {
            $verificationMessage = "Invalid verification code. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sign Up & Verify - SmartFarm</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="main.css" rel="stylesheet">
</head>
<body class="blog-page">
<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/our logo.png" alt="AgriCulture">
        <h1 class="sitename">smartfarm</h1> 
      </a>
    </div>
</header>
<main class="main">
  <div class="container" style="max-width: 500px; margin: 50px auto;">
    <h1>Register</h1>
    <form action="signup.php" method="POST">
        <div class="form-group">
            <label for="prenom">First Name</label>
            <input type="text" class="form-control" name="prenom" id="prenom" value="<?= htmlspecialchars($prenom) ?>" required>
        </div>
        <div class="form-group">
            <label for="nom">Last Name</label>
            <input type="text" class="form-control" name="nom" id="nom" value="<?= htmlspecialchars($nom) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
    <label for="role">Role</label>
    <select name="role" class="form-control" id="role" required>
        <option value="Client" <?= $role == "Client" ? 'selected' : '' ?>>Client</option>
        <option value="Admin" <?= $role == "Admin" ? 'selected' : '' ?>>Admin</option>
        <option value="AgriCulture" <?= $role == "AgriCulture" ? 'selected' : '' ?>>AgriCulture</option>
        <option value="Livreur" <?= $role == "Livreur" ? 'selected' : '' ?>>Livreur</option>
    </select>
</div>

        <br>
        <button type="submit" name="signup" class="btn btn-primary w-100">Sign Up</button>
        <?php if (!empty($errorMessage)): ?>
            <p class="text-danger"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <p class="text-success"><?= htmlspecialchars($successMessage) ?></p>
        <?php endif; ?>
    </form>
    <br>
    <h1>Verify Your Email</h1>
    <form action="signup.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="code">Verification Code</label>
            <input type="text" class="form-control" name="code" id="code" required>
        </div>
        <button type="submit" name="verify" class="btn btn-primary w-100">Verify</button>
        <?php if (!empty($verificationMessage)): ?>
            <p class="text-success"><?= htmlspecialchars($verificationMessage) ?></p>
        <?php endif; ?>
    </form>
  </div>
</main>
<footer id="footer" class="footer dark-background">
  <div class="container">
    <p>SmartFarm &copy; 2024</p>
  </div>
</footer>
</body>
</html>
