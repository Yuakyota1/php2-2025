<?php
require_once "Database.php";

class ProductSizeColorModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function getSizeColorsByProductId($productId) {
        $sql = "SELECT color, nameSize, price, quantity 
                FROM product_size_color 
                WHERE product_id = :productId";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllProductSizeColors() {
        $query = "SELECT * FROM product_size_color";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductSizeColorById($id) {
        $query = "SELECT * FROM product_size_color WHERE idSizeColor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProducts() {
        $query = "SELECT idProduct, name FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSizes() {
        $query = "SELECT idSize, nameSize FROM sizes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getQuantityById($product_id, $color, $size) {
        $sql = "SELECT quantity FROM product_size_color WHERE idProduct = ? AND color = ? AND idSize = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$product_id, $color, $size]);
        return $stmt->fetchColumn() ?: 1; // Nếu không tìm thấy, mặc định trả về 1
    }
    
    public function createProductSizeColor($idProduct, $color, $idSize, $quantity, $price, $image = null) {
        if ($image) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image);

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo "Error uploading the file.";
                return false;
            }
        }

        $query = "INSERT INTO product_size_color (idProduct, color, idSize, quantity, price, image) VALUES (:idProduct, :color, :idSize, :quantity, :price, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':idSize', $idSize);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function updateProductSizeColor($id, $idProduct, $color, $idSize, $quantity, $price, $image = null) {
        if ($image) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image);

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo "Error uploading the file.";
                return false;
            }
            
            $query = "UPDATE product_size_color SET idProduct = :idProduct, color = :color, idSize = :idSize, quantity = :quantity, price = :price, image = :image WHERE idSizeColor = :id";
        } else {
            $query = "UPDATE product_size_color SET idProduct = :idProduct, color = :color, idSize = :idSize, quantity = :quantity, price = :price WHERE idSizeColor = :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':idSize', $idSize);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        if ($image) {
            $stmt->bindParam(':image', $image);
        }
        return $stmt->execute();
    }

    public function isColorExists($idProduct, $color, $idSize, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT COUNT(*) FROM product_size_color 
                      WHERE idProduct = :idProduct AND color = :color AND idSize = :idSize AND idSizeColor != :excludeId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':excludeId', $excludeId);
        } else {
            $query = "SELECT COUNT(*) FROM product_size_color 
                      WHERE idProduct = :idProduct AND color = :color AND idSize = :idSize";
            $stmt = $this->conn->prepare($query);
        }

        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':idSize', $idSize);

        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function deleteProductSizeColor($id) {
        $query = "DELETE FROM product_size_color WHERE idSizeColor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
} 
?>
