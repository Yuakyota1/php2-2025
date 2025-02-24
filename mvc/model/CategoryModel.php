<?php
require_once "Database.php";

class CategoryModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getCategoryById($category_id) {
        $query = "SELECT * FROM categories WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCategory($category_name) {  // Đổi từ 'name' thành 'category_name'
        $query = "INSERT INTO categories (category_name) VALUES (:category_name)";  // Đổi từ 'name' thành 'category_name'
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_name', $category_name);  // Đổi từ 'name' thành 'category_name'
        return $stmt->execute();
    }

    public function updateCategory($category_id, $category_name) {  // Đổi từ 'name' thành 'category_name'
        $query = "UPDATE categories SET category_name = :category_name WHERE category_id = :category_id";  // Đổi từ 'name' thành 'category_name'
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':category_name', $category_name);  // Đổi từ 'name' thành 'category_name'
        return $stmt->execute();
    }

    public function deleteCategory($category_id) {
        $query = "DELETE FROM categories WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        return $stmt->execute();
    }
}
?>
