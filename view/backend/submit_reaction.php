<?php
require_once '../../controller/ProductController.php';
require_once 'C:\xampp\htdocs\smartfarmproduit2.6\nour.php';

$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $reaction = $_POST['reaction'];

    if ($reaction === 'like') {
        $productController->addLike($productId);
    } elseif ($reaction === 'dislike') {
        $productController->addDislike($productId);
    }

    header("Location: listprod.php"); // Redirect back to product listing
}
?>