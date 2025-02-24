<?php
require_once "Database.php";

class ImageModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllImages()
    {
        $query = "SELECT * FROM images";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImageById($image_id)
    {
        $query = "SELECT * FROM images WHERE image_id  = :image_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':image_id', $image_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function associateProductWithImage($productId, $imageId) {
        $stmt = $this->conn->prepare("INSERT INTO product_images (product_id, image_id) VALUES (?, ?)");
        $stmt->execute([$productId, $imageId]);
    }
    
    public function getImagesByProductId($productId)
    {
        $sql = "SELECT i.name, i.path 
                FROM images i 
                INNER JOIN product_images pi ON i.image_id = pi.image_id 
                WHERE pi.product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function createImage($fileName, $filePath)
    {
        $query = "INSERT INTO images (name, path) VALUES (:name, :path)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $fileName);
        $stmt->bindParam(':path', $filePath);
        $stmt->execute();
    }

    public function updateImage($id, $newName) {
        // Lấy tên tệp hiện tại từ cơ sở dữ liệu
        $query = "SELECT name FROM images WHERE image_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $currentName = $stmt->fetchColumn();
    
        if ($currentName) {
            // Đổi tên tệp trong thư mục uploads
            $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $currentName;
            $newFilePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $newName;
    
            // Kiểm tra nếu tệp cũ tồn tại và đổi tên tệp
            if (file_exists($oldFilePath)) {
                rename($oldFilePath, $newFilePath);
            }
    
            // Cập nhật tên trong cơ sở dữ liệu
            $updateQuery = "UPDATE images SET name = :name WHERE image_id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':name', $newName);
            $updateStmt->bindParam(':id', $id);
    
            // Thực thi cập nhật
            return $updateStmt->execute();
        }
        return false;
    }
    

    public function deleteImage($id) {
        // Xóa các bản ghi trong bảng product_images liên quan đến image_id
        $query = "DELETE FROM product_images WHERE image_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        // Sau đó xóa bản ghi trong bảng images
        $query = "DELETE FROM images WHERE image_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
}    
