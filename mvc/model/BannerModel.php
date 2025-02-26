<?php
require_once "Database.php";

class BannerModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllBanners() {
        $query = "SELECT * FROM banners ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBannerById($banner_id) {
        $query = "SELECT * FROM banners WHERE banner_id = :banner_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':banner_id', $banner_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBanner($title, $image) {
        $query = "INSERT INTO banners (title, image) VALUES (:title, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function updateBanner($banner_id, $title, $image) {
        $query = "UPDATE banners SET title = :title, image = :image WHERE banner_id = :banner_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':banner_id', $banner_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function deleteBanner($banner_id) {
        $query = "DELETE FROM banners WHERE banner_id = :banner_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':banner_id', $banner_id);
        return $stmt->execute();
    }
}
?>
