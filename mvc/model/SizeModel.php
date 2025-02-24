<?php
require_once "Database.php";

class SizeModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllSizes() {
        $query = "SELECT * FROM sizes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function isSizeNameExists($nameSize, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT COUNT(*) FROM sizes WHERE nameSize = :nameSize AND idSize != :excludeId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nameSize', $nameSize);
            $stmt->bindParam(':excludeId', $excludeId);
        } else {
            $query = "SELECT COUNT(*) FROM sizes WHERE nameSize = :nameSize";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nameSize', $nameSize);
        }
    
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    

    public function getSizeById($id) {
        $query = "SELECT * FROM sizes WHERE idSize = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSize($name) {
        $query = "INSERT INTO sizes (nameSize) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public function updateSize($id, $name) {
        $query = "UPDATE sizes SET nameSize = :name WHERE idSize = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public function deleteSize($id) {
        $query = "DELETE FROM sizes WHERE idSize = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
