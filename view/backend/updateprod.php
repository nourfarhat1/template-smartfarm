<?php
include '../../controller/ProductController.php';
require_once 'C:\xampp\htdocs\smartfarmproduit2.6\nour.php';
include "../../controller/CategorieController.php";

$productController = new ProductController();
$categoryController = new CategoryController();
$categories = $categoryController->listCategories();
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idprod = $_POST['idprod'];
    $nomprod = $_POST['nomprod'] ?? null;
    $nomcategorie = $_POST['nomcategorie'] ?? null;
    $priceprod = $_POST['priceprod'] ?? null;
    $descriptionprod = $_POST['descriptionprod'] ?? null;

    // Handle image upload
    $imageprod = null;
    if (isset($_FILES['imageprod']) && $_FILES['imageprod']['error'] === UPLOAD_ERR_OK) {
        $imageprod = file_get_contents($_FILES['imageprod']['tmp_name']);
    }

    // Fetch existing product
    $productToEdit = $productController->showProduct($idprod);
    if (!$productToEdit) {
        $error = "Product not found.";
    } else {
        // Use existing image if no new image is uploaded
        $imageprod = $imageprod ?? $productToEdit['imageprod'];

        // Create product object
        $product = new Product(
            $idprod,
            $nomprod,
            $nomcategorie,
            $priceprod,
            $descriptionprod,
            $imageprod
        );

        // Attempt update
        if ($productController->updateProduct($product)) {
            header('Location: listprod.php');
            exit;
        } else {
            $error = "Failed to update product.";
        }
    }
}

// Fetch product details for pre-filling the form
$productToEdit = null;
if (isset($_GET['idprod'])) {
    $productToEdit = $productController->showProduct($_GET['idprod']);
    if (!$productToEdit) {
        $error = "Product not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Marcellus:wght@400&display=swap" rel="stylesheet">
  <link href="../backend/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../backend/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../backend/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../backend/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../backend/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../frontend/main.css" rel="stylesheet">
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
    <div class="card p-4">
        <h2 class="text-center">Update Product</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form id="productForm" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idprod" value="<?= htmlspecialchars($productToEdit['idprod'] ?? ''); ?>">
            <div class="mb-3">
                <label for="nomprod" class="form-label">Product Name</label>
                <input type="text" name="nomprod" class="form-control" id="nomprod" 
                    value="<?= htmlspecialchars($productToEdit['nomprod'] ?? ''); ?>" >
            </div>
            <div class="mb-3">
                <label for="nomcategorie" class="form-label">Category</label>
                <select name="nomcategorie" class="form-select" id="nomcategorie" >
                    <option value="" disabled selected>Select a category</option>
                    <?php foreach ($categories as $category): ?>
                       <option value="<?= htmlspecialchars($category['nomcategorie']); ?>" <?= (htmlspecialchars($category['nomcategorie']) == htmlspecialchars($productToEdit['nomcategorie'])) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($category['nomcategorie']); ?>
                      </option>
                     <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="descriptionprod" class="form-label">Product Description</label>
                <textarea name="descriptionprod" class="form-control" id="descriptionprod" rows="4"><?= htmlspecialchars($productToEdit['descriptionprod'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="priceprod" class="form-label">Price ($)</label>
                <input type="number" name="priceprod" class="form-control" id="priceprod" 
                    value="<?= htmlspecialchars($productToEdit['priceprod'] ?? ''); ?>" step="0.01">
            </div>
            <div class="mb-3">
                <label for="imageprod" class="form-label">Product Image (optional)</label>
                <input type="file" name="imageprod" class="form-control" id="imageprod" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success w-100" aria-label="Update Product">Update Product</button>
        </form>
    </div>
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

  <script>
    document.getElementById('productForm').addEventListener('submit', function(event) {
      let errorMessage = "";
      let isValid = true;

      // Validate Product Name
      let productName = document.getElementById('nomprod').value.trim();
      if (!productName) {
        errorMessage += "Product name is required.\n";
        isValid = false;
      }

      // Validate Product Description
      let productDescription = document.getElementById('descriptionprod').value.trim();
      if (!productDescription) {
        errorMessage += "Product description is required.\n";
        isValid = false;
      }

      // Validate Product Price
      let productPrice = document.getElementById('priceprod').value.trim();
      if (!productPrice || isNaN(productPrice) || parseFloat(productPrice) < 0.01) {
        alert("Price must be greater than or equal to 0.01.");
        isValid = false;
      }

      // Validate Category
      let productCategory = document.getElementById('nomcategorie').value;
      if (!productCategory) {
        errorMessage += "Please select a category.\n";
        isValid = false;
      }

      // Validate Image (Optional)
      let productImage = document.getElementById('imageprod').files[0];
      if (productImage && !productImage.type.startsWith('image/')) {
        errorMessage += "Please upload a valid image file.\n";
        isValid = false;
      }

      if (!isValid) {
        if (errorMessage) {
          alert(errorMessage);
        }
        event.preventDefault();
      }
    });
  </script>
</body>
</html>