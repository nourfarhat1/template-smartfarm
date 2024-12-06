<?php
include_once(__DIR__ . '/../../controller/event_controller.php');
include_once(__DIR__ . '/../../config.php');
$userid = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $disc = $_POST['disc'];
    $date = $_POST['date'];

    $conn = config::getConnexion();

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO event (nom, disc, date) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $disc);
        $stmt->bindParam(3, $date);

        if ($stmt->execute()) {
            $stmt = $conn->prepare("SELECT id_e FROM event WHERE nom = ? AND disc = ? AND date = ?");
            $stmt->bindParam(1, $nom);
            $stmt->bindParam(2, $disc);
            $stmt->bindParam(3, $date);
            $stmt->execute();

            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            $eventId = $event['id_e'];

            $stmtUserEvent = $conn->prepare("INSERT INTO acceder_event (id_utilisateur, id_e) VALUES (?, ?)");
            $stmtUserEvent->bindParam(1, $userid);
            $stmtUserEvent->bindParam(2, $eventId);

            if ($stmtUserEvent->execute()) {
                $conn->commit();
                echo "L'événement a été ajouté et l'utilisateur a été associé avec succès !";
            } else {
                $conn->rollBack();
                echo "Erreur lors de l'ajout de l'utilisateur à l'événement.";
            }
        } else {
            $conn->rollBack();
            echo "Erreur lors de l'ajout de l'événement.";
        }
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Erreur: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
  <style>
    .image-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .clickable-image {
      width: 200px;
      height: 150px;
      object-fit: cover;
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .clickable-image:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body class="services-page">

  <header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/our logo.png" alt="Agrivatorslogo">
        <h1 class="sitename">smartfarm</h1> 
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#" class="active">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Our Services</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Login</a></li>
          <li><a href="#">Reclamations</a></li>
          <li><a href="#">Panier</a></li>
          <li><a href="#">Events</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Ajouter un evenement</h1>
      </div>
    </div>

    <section id="services" class="services section">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            <h2>Ajouter un evenement</h2>
            <form id="eventForm" method="POST" action="add.php">
                <label for="nom">Nom de l'événement:</label><br>
                <input type="text" id="nom" name="nom"><br><br>

                <label for="disc">Description de l'événement:</label><br>
                <textarea id="disc" name="disc" ></textarea><br><br>

                <label for="date">Date de l'événement:</label><br>
                <input type="date" id="date" name="date" ><br><br>

                <input type="submit" value="Ajouter l'événement">
            </form>
          </div>
        </div>
      </div>
    </section>
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
              <p class="mt-3"><strong>Phone:</strong> <span>53 *** ***</span></p>
              <p><strong>Email:</strong> <span>agri.vators@gmail.com</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="main.js"></script>

  <script>
    document.getElementById('eventForm').addEventListener('submit', function(event) {
      // Validation for non-empty values
      const nom = document.getElementById('nom').value;
      const disc = document.getElementById('disc').value;
      const date = document.getElementById('date').value;

      if (!nom || !disc || !date) {
        alert("Tous les champs sont obligatoires.");
        event.preventDefault();  // Prevent form submission
      } else if (new Date(date) < new Date()) {
        alert("La date de l'événement ne peut pas être dans le passé.");
        event.preventDefault();
      }
    });
  </script>

</body>
</html>
