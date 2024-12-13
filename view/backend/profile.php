<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdata";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user ID from the session
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id']; // Get the user ID from session
} else {
    // If user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Retrieve user details from the database
$sql = "SELECT nom, prenom, email, profile_image FROM agriculture_users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($nom, $prenom, $email, $profileImage);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>

  <!-- Bootstrap CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="main.css" rel="stylesheet">

</head>

<body>

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/our logo.png" alt="AgriCulture">
        <h1 class="sitename">SmartFarm</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About Us</a></li>
          <li><a href="NOURservices.html" class="active">Services</a></li>
          <li><a href="AHMEDblog.html">Blog</a></li>
          <li><a href="NASSIMlogin.html">Login</a></li>
          <li><a href="AZIZreclamation.html">Reclamations</a></li>
          <li><a href="SAMERpanier.html">Panier</a></li>
          <li><a href="MAYSSOUNevents.html">Events</a></li>
        </ul>
      </nav>

    </div>
  </header>

  <!-- Main Content -->
  <main class="main">
    <div class="container" style="max-width: 600px; margin-top: 50px;">
      <h1 class="text-center">Your Profile</h1>
      <form action="../backend/update_user.php" method="post" enctype="multipart/form-data">

        <!-- Profile Image Section -->
        <div class="text-center mb-4">
          <!-- If there is a profile image, show it, otherwise display a default one -->
          <img id="profile-img" src="<?php echo !empty($profileImage) ? 'uploads/' . $profileImage : './assets/img/person-circle.svg'; ?>" class="rounded-circle" alt="Profile_Image" width="150" height="150">
          <br><br>
          <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
        </div>

        <!-- Name and Email -->
        <div class="mb-3">
          <label for="nom" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
        </div>

        <div class="mb-3">
          <label for="prenom" class="form-label">First Name</label>
          <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if not changing">
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer id="footer" class="footer dark-background">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <img src="assets/img/our logo.png" alt="Agrivatorslogo">
              <h1 class="sitename">SmartFarm</h1>
            </a>
            <div class="footer-contact pt-3">
              <p>Tunisia, Esprit</p>
              <p class="mt-3"><strong>Phone:</strong> <span>53 *** *** </span></p>
              <p><strong>Email:</strong> <span>agri.vators@example.com</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS & Additional JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="main.js"></script>

</body>
</html>