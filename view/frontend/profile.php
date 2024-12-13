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

  <!-- PHP: Fetch User Data -->
  <?php
  session_start();

  // Ensure the user is logged in
  if (!isset($_SESSION['user_id'])) {
      header("Location: signin.php");
      exit();
  }

  // Database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "smartf"; // Your database name

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Fetch user details using user_id stored in session
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM users WHERE id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
  } else {
      echo "<div class='alert alert-danger text-center'>User not found.</div>";
      exit();
  }
  ?>

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/our logo.png" alt="SmartFarm Logo">
        <h1 class="sitename">SmartFarm</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About Us</a></li>
          <li><a href="NOURservices.html" class="active">Services</a></li>
          <li><a href="AHMEDblog.html">Blog</a></li>
          <li><a href="index.php">Reclamations</a></li>
          <li><a href="SAMERpanier.html">Panier</a></li>
          <li><a href="MAYSSOUNevents.html">Events</a></li>
          <li><span><?php echo htmlspecialchars($_SESSION['role']); ?></span></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main">
    <div class="container" style="max-width: 600px; margin-top: 50px;">
      <h1 class="text-center">Your Profile</h1>
      <form action="../backend/profile_update.php" method="post" enctype="multipart/form-data">

        <!-- Profile Image Section -->
        <div class="text-center mb-4">
          <img id="profile-img" 
               src="<?php echo !empty($user['profile_image']) ? 'uploads/' . htmlspecialchars($user['profile_image']) : './assets/img/person-circle.svg'; ?>" 
               class="rounded-circle" 
               alt="Profile Image" 
               width="150" 
               height="150">
          <br><br>
          <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
        </div>

        <!-- Name and Email -->
        <div class="mb-3">
          <label for="nom" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
        </div>

        <div class="mb-3">
          <label for="prenom" class="form-label">First Name</label>
          <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
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
              <img src="assets/img/our logo.png" alt="SmartFarm Logo">
              <h1 class="sitename">SmartFarm</h1>
            </a>
            <div class="footer-contact pt-3">
              <p>Tunisia, Esprit</p>
              <p class="mt-3"><strong>Phone:</strong> <span>53 *** ***</span></p>
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