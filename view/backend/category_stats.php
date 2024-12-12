<?php
include '../../controller/ProductController.php';
require_once 'C:\xampp\htdocs\smartfarmproduit2.6\nour.php';

// Instantiate the ProductController
$productController = new ProductController();
$categoryCounts = $productController->countProductsByCategory();

if (empty($categoryCounts)) {
    echo "<p>No categories found.</p>";
    return; // Stop further processing
}

// Sort the categories by product count in descending order
usort($categoryCounts, function($a, $b) {
    return $b['product_count'] <=> $a['product_count'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="../backend/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../backend/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../backend/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../backend/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../backend/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    
    <!-- Main CSS File -->
    <link href="../frontend/main.css" rel="stylesheet">
    
    <title>Category Statistics</title>
</head>
<body>

<header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="../backend/assets/img/our logo.png" alt="Agrivatorslogo">
            <h1 class="sitename">smartfarm</h1> 
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="../frontend/index.html">Home</a></li>
                <li><a href="../frontend/about.html">About Us</a></li>
                <li><a href="../frontend/NOURservices.html" class="btn text-white px-3 py-2 rounded active" style="background-color: black; border: none;">Your Services</a></li>
                <li><a href="../frontend/AHMEDblog.html">Blog</a></li>
                <li><a href="../frontend/NASSIMlogin.html">Login</a></li>
                <li><a href="../frontend/AZIZreclamation.html">Reclamations</a></li>
                <li><a href="../frontend/SAMERpanier.html">Panier</a></li>
                <li><a href="../frontend/MAYSSOUNevents.html">Events</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<main class="container my-5">
    <h2 class="text-center">Product Category Distribution</h2>
    <table class="table table-striped table-bordered mt-4">
        <thead class="table-light">
            <tr>
                <th>Category Name</th>
                <th>Product Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoryCounts as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['nomcategorie']); ?></td>
                    <td><?= htmlspecialchars($category['product_count']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<footer id="footer" class="footer dark-background">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <img src="../backend/assets/img/our logo.png" alt="Agrivatorslogo">
                        <h1 class="sitename">smartfarm</h1> 
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Tunisia, Esprit</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>53 *** ***</span></p>
                        <p><strong>Email:</strong> <span>agri.vators@gmail.com</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="../backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../backend/main.js"></script>
</body>
</html>