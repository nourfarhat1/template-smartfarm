<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../model/event_model.php');

class EventController {

    private $eventModel;

    public function __construct() {
        $this->eventModel = new EventModel();
    }

    public function addEvent(Event $event) {
        $this->eventModel->addEvent($event->getNom(), $event->getDisc(), $event->getDate());
        echo "Event added successfully!";
    }

    public function updateEvent(Event $event) {
        $this->eventModel->updateEvent($event->getId(), $event->getNom(), $event->getDisc(), $event->getDate());
        echo "Event updated successfully!";
    }

    public function deleteEvent($id) {
        $this->eventModel->deleteEvent($id);
        echo "Event deleted successfully!";
    }

    public function showEvent($id) {
        $event = $this->eventModel->getEventById($id);
        if ($event) {
            return $event;  
        } else {
            return null; 
        }
    }
    

    public function showAllEvents() {
        $events = $this->eventModel->getAllEvents();
    
        if ($events) {
            // Start of the HTML structure
            echo '<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">
  <!-- Fonts -->
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
      flex-wrap: wrap; /* Ensure images wrap on smaller screens */
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
          <li><a href="#">blog</a></li>
          <li><a href="#">login</a></li>
          <li><a href="#">reclamations</a></li>
          <li><a href="#">panier</a></li>
          <li><a href="#">events</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Tableau De Bored Des Evenements</h1>
      </div>
    </div>

    <!-- Services Section -->
    <section id="services" class="services section">
      <!-- Section Title -->
      
    </section>
  </main>
</body>
    
                <section id="services" class="services section">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Event ID</th>
                                <th>Event Name</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
            
                        // Loop through events and display them in the table
                        foreach ($events as $event) {
                            echo '<tr>';
                            echo '<td>' . $event['id_e'] . '</td>';
                            echo '<td>' . $event['nom'] . '</td>';
                            echo '<td>' . $event['disc'] . '</td>';
                            echo '<td>' . $event['date'] . '</td>';
                            echo '<td>';
                            echo '<a href="edit.php?id=' . $event['id_e'] . '">Edit</a> | ';
                            echo '<a href="delete.php?id=' . $event['id_e'] . '" onclick="return confirm(\'Are you sure you want to delete this event?\')">Delete</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
            
                        // Close the table and body tags
                        echo '</tbody></table>';
            
                    echo '</section>
                </main>';
    
                // Footer HTML
                echo '
            
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
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="main.js"></script>

</body>

</html>
';
    
        } else {
            echo "No events found!";
        }
    }
    
    public function showAllEvents2() {
        $events = $this->eventModel->getAllEvents();
    
        if ($events) {
            // Start of the HTML structure
            echo '<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">
  <!-- Fonts -->
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
      flex-wrap: wrap; /* Ensure images wrap on smaller screens */
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
          <li><a href="#">blog</a></li>
          <li><a href="#">login</a></li>
          <li><a href="#">reclamations</a></li>
          <li><a href="#">panier</a></li>
          <li><a href="#">events</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Tableau De Bored Des Evenements</h1>
      </div>
    </div>

    <!-- Services Section -->
    <section id="services" class="services section">
      <!-- Section Title -->
      
    </section>
  </main>
</body>
    
                <section id="services" class="services section">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Event ID</th>
                                <th>Event Name</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>';
            
                        // Loop through events and display them in the table
                        foreach ($events as $event) {
                            echo '<tr>';
                            echo '<td>' . $event['id_e'] . '</td>';
                            echo '<td>' . $event['nom'] . '</td>';
                            echo '<td>' . $event['disc'] . '</td>';
                            echo '<td>' . $event['date'] . '</td>';
                            echo '<td>';
                            echo '</td>';
                            echo '</tr>';
                        }
            
                        // Close the table and body tags
                        echo '</tbody></table>';
            
                    echo '</section>
                </main>';
    
                echo '
            
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
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="main.js"></script>

</body>

</html>';
    
        } else {
            echo "No events found!";
        }
    }
}
?>
