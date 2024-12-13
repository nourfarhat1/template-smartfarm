<?php
require_once __DIR__ . '/../nour.php';
include __DIR__ . '/../model/product.php';

class ProductController
{
    private $db;

    public function __construct($db = null)
    {
        $this->db = $db ?: nour::getConnexion();
    }

    public function listProducts()
    {
        $sql = "SELECT * FROM products";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function addProduct($product)
    {
        $sqlCheckCategory = "SELECT * FROM categories WHERE nomcategorie = :nomcategorie";
        $nour = nour::getConnexion();

        try {
            $stmtCheck = $nour->prepare($sqlCheckCategory);
            $stmtCheck->bindValue(':nomcategorie', $product->getNomCategorie(), PDO::PARAM_STR);
            $stmtCheck->execute();

            if ($stmtCheck->rowCount() === 0) {
                echo "Category does not exist!";
                return false;
            }

            // Prepare the SQL to insert the product including the image
            $sql = "INSERT INTO products (nomprod, priceprod, descriptionprod, nomcategorie, imageprod)
                    VALUES (:nomprod, :priceprod, :descriptionprod, :nomcategorie, :imageprod)";

            $query = $nour->prepare($sql);
            $params = [
                'nomprod' => $product->getNomProd(),
                'priceprod' => $product->getPriceProd(),
                'descriptionprod' => $product->getDescriptionProd(),
                'nomcategorie' => $product->getNomCategorie(),
                'imageprod' => $product->getImageProd()  // Assuming this method retrieves the image data
            ];

            $query->execute($params);
            echo "Product added successfully!";
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function showProduct($idprod)
    {
        $sql = "SELECT * FROM products WHERE idprod = :idprod";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idprod', $idprod, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    public function listProductsByCategory($categoryName)
    {
        $sql = "SELECT * FROM products WHERE nomcategorie = :nomcategorie";
        $nour = nour::getConnexion();
    
        try {
            $stmt = $nour->prepare($sql);
            $stmt->bindValue(':nomcategorie', $categoryName, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function deleteProduct($idprod)
    {
        $sql = "DELETE FROM products WHERE idprod = :idprod";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idprod', $idprod, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function updateProduct($product) {
    $nour = nour::getConnexion();

    try {
        // Fetch current values from the database
        $sqlFetch = "SELECT * FROM products WHERE idprod = :idprod";
        $stmtFetch = $nour->prepare($sqlFetch);
        $stmtFetch->bindValue(':idprod', $product->getIdProd(), PDO::PARAM_INT);
        $stmtFetch->execute();
        $currentProduct = $stmtFetch->fetch();

        if (!$currentProduct) {
            echo "Product not found.";
            return false;
        }

        // Retain current values if fields are not updated
        $updatedValues = [
            'nomprod' => $product->getNomProd() ?? $currentProduct['nomprod'],
            'priceprod' => $product->getPriceProd() ?? $currentProduct['priceprod'],
            'descriptionprod' => $product->getDescriptionProd() ?? $currentProduct['descriptionprod'],
            'nomcategorie' => $product->getNomCategorie() ?? $currentProduct['nomcategorie'],
            'imageprod' => $product->getImageProd() ?? $currentProduct['imageprod'],
        ];

        // Validate nomcategorie if updated
        if ($product->getNomCategorie() !== null) {
            $sqlCheckCategory = "SELECT nomcategorie FROM categories WHERE nomcategorie = :nomcategorie";
            $stmtCheck = $nour->prepare($sqlCheckCategory);
            $stmtCheck->bindValue(':nomcategorie', $product->getNomCategorie(), PDO::PARAM_STR);
            $stmtCheck->execute();

            if ($stmtCheck->rowCount() === 0) {
                echo "Invalid category. Update aborted.";
                return false;
            }
        }

        // Update query
        $sqlUpdate = "UPDATE products 
                      SET nomprod = :nomprod,
                       priceprod = :priceprod, 
                       descriptionprod = :descriptionprod, 
                       nomcategorie = :nomcategorie, 
                       imageprod = :imageprod 
                      WHERE idprod = :idprod";
        $stmtUpdate = $nour->prepare($sqlUpdate);

        $stmtUpdate->bindValue(':nomprod', $updatedValues['nomprod'], PDO::PARAM_STR);
        $stmtUpdate->bindValue(':priceprod', $updatedValues['priceprod'], PDO::PARAM_STR);
        $stmtUpdate->bindValue(':descriptionprod', $updatedValues['descriptionprod'], PDO::PARAM_STR);
        $stmtUpdate->bindValue(':nomcategorie', $updatedValues['nomcategorie'], PDO::PARAM_STR);
        $stmtUpdate->bindValue(':imageprod', $updatedValues['imageprod'], PDO::PARAM_LOB);
        $stmtUpdate->bindValue(':idprod', $product->getIdProd(), PDO::PARAM_INT);

        $stmtUpdate->execute();

        echo "Product updated successfully!";
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

}