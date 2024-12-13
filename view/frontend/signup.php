<?php
// Database connection
$host = "localhost";
$dbname = "smartf";
$username = "root";
$password = "";

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$prenom = $nom = $email = $password = $role = "";
$errorMessage = $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

        // Hash the password

        // Insert data
        $sql = "INSERT INTO users (prenom, nom, email, password, role) VALUES (:prenom, :nom, :email, :password, :role)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        try {
            $stmt->execute();
            $successMessage = "Account successfully created.";
            // Redirect after successful registration
            header("Location: signin.php");
            exit; // Always exit after header to prevent further execution
        } catch (PDOException $e) {
            $errorMessage = "Error inserting data: " . $e->getMessage();
        }
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Blog - AgriCulture Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="main.css" rel="stylesheet">
</head>
<body class="blog-page">
<header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/our logo.png" alt="AgriCulture">
        <h1 class="sitename">smartfarm</h1> 
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About Us</a></li>
          <li><a href="NOURservices.html" class="active">Services</a></li>
          <li><a href="AHMEDblog.html">blog</a></li>
          <li><a href="signin.php">login</a></li>          <li><a href="AZIZreclamation.html">reclamations</a></li>
          <li><a href="SAMERpanier.html">panier</a></li>
          <li><a href="MAYSSOUNevents.html">events</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>
  <main class="main">

  <div class="container" style="max-width: 500px; margin: 50px auto;">
  
    <h1>Register</h1><br>
    <div class="container">
       
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="prenom" class="form-label">First Name</label>
                <input type="text" class="form-control"  name="prenom" id="prenom" value="<?= htmlspecialchars($prenom) ?>" required>
            </div>
            <div class="form-group">
                <label for="nom" class="form-label" >Name</label>
                <input type="text" class="form-control"  name="nom" id="nom" value="<?= htmlspecialchars($nom) ?>" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control"  name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control"  name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <br><select name="role" id="role" required>
                    <option value="Client" <?= $role == "Client" ? 'selected' : '' ?>>Client</option>
                    <option value="admin" <?= $role == "admin" ? 'selected' : '' ?>>Admin</option>
                    <option value="AgriCulture" <?= $role == "AgriCulture" ? 'selected' : '' ?>>AgriCulture</option>
                    <option value="Livreur" <?= $role == "Livreur" ? 'selected' : '' ?>>Livreur</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary w-100" >Sign Up</button>
            <?php if (!empty($errorMessage)): ?>
                <p class="error"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>
            <?php if (!empty($successMessage)): ?>
                <p class="success"><?= htmlspecialchars($successMessage) ?></p>
            <?php endif; ?>
        </form>
    </div>
    </main>
    
  <footer id="footer" class="footer dark-background">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <img src="assets/img/our logo.png" alt="Agrivatorslogo">
              <h1 class="sitename">smartfarm</h1> 
            </a>
            <div class="footer-contact pt-3">
              <p>tunisia , esprit</p>
              <p class="mt-3"><strong>Phone:</strong> <span>53 *** *** </span></p>
              <p><strong>Email:</strong> <span>agri.vators@example.com</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>


</body>
</html>
