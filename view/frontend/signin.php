<?php
// Declare variables
$email = "";
$password = "";
$errorMessage = "";
$successMessage = "";

// Database connection (replace with your database connection code)
$host = "localhost";
$dbname = "smartf";
$username = "root";
$password_db = "";  // Use a different variable name for the database password to avoid conflict

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    do {
        // Check if the fields are empty
        if (empty($email) || empty($password)) {
            $errorMessage = "Both email and password are required.";
            break;
        }

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If no user found
        if (!$user) {
            $errorMessage = "No user found with this email.";
            break;
        }

        echo "Database password: " . $user['password'] . "<br>";
        echo "Entered password: $password <br>";
        
        // Verify the password using password_verify
        if (!password_verify($password, $user['password'])) {
            $errorMessage = "Incorrect password.";
            break;
        }

        // Set the session
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
          
        echo "<script>alert('Login successful!'); window.location.href =  'http://localhost/tempfinal/view/frontend/profile.php';</script>";
        
        // Redirect based on the role
        if ($user['role'] === "admin") {
            header("location: ../admin/dashboard.php");
        }
        exit;
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
<!--javascript-->

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
          <!--<li><a href="NOURservices.html" class="active">Services</a></li>
          <li><a href="AHMEDblog.html">blog</a></li>
          <li><a href="NASSIMlogin.html">login</a></li>
          
          <li><a href="SAMERpanier.html">panier</a></li>    
          <li><a href="MAYSSOUNevents.html">events</a></li>-->
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

  <div class="container" style="max-width: 500px; margin: 50px auto;">
  
  <!-- Profile Image Section -->
  <div class="text-center mb-4">
          <!-- If there is a profile image, show it, otherwise display a default one -->
          <img id="login_image.jpg" src="<?php echo !empty($profileImage) ? 'uploads/' . $profileImage : './assets/img/login_image.jpg'; ?>" class="rounded-circle" alt="Profile_Image" width="150" height="150">
          <br><br>
        </div>
  <br>
        <form action="signin.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
                <input type="email"  class="form-control"  name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="mb-3">
                <label  class="form-label"for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
            <a a href="signup.php">Register Now!</a>
            <?php if (!empty($errorMessage)): ?>
                <p class="error"><?= $errorMessage ?></p>
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
