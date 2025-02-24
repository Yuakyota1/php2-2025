<?php
require_once "Database.php";

class ProductModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả sản phẩm với hình ảnh và danh mục
    public function getAllProducts() {
        $query = "SELECT p.idProduct, p.name, p.description, c.category_name, p.images 
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Chuyển đổi chuỗi hình ảnh thành mảng
        foreach ($products as &$product) {
            if (!empty($product['images'])) {
                $product['images'] = explode(',', $product['images']);
            } else {
                $product['images'] = []; // Nếu không có hình ảnh nào
            }
        }
    
        return $products;
    }
    
    public function getRelatedProducts($categoryId, $excludeProductId) {
        $sql = "SELECT * FROM products WHERE category_id = ? AND idProduct != ? LIMIT 4";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$categoryId, $excludeProductId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy thông tin chi tiết sản phẩm theo id với danh mục
    public function getProductById($idProduct) {
        $sql = "SELECT p.*, c.category_name 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.idProduct = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idProduct]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Chuyển đổi chuỗi hình ảnh thành mảng
        if (!empty($product['images'])) {
            $product['images'] = explode(',', $product['images']); // Chuyển đổi thành mảng
        } else {
            $product['images'] = []; // Nếu không có hình ảnh nào
        }
        
    
        return $product;
    }
    

    public function getImagesByProductId($productId) {
        // Truy vấn để lấy hình ảnh cho sản phẩm dựa trên idProduct
        $sql = "SELECT images FROM products WHERE idProduct = :productId"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Kiểm tra kết quả và chuyển đổi chuỗi hình ảnh thành mảng
        if ($result && !empty($result['images'])) {
            return explode(',', $result['images']);
        }
        return []; // Trả về mảng rỗng nếu không tìm thấy hình ảnh
    }
    
    public function getProductsByCategory($categoryId) {
        $query = "SELECT * FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSizeColorsByProductId($productId)
    {
        $sql = "SELECT psc.*, s.nameSize 
                FROM product_size_color psc
                LEFT JOIN sizes s ON psc.idSize = s.idSize
                WHERE psc.idProduct = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tạo sản phẩm mới
   // Cập nhật phương thức createProduct
  // Cập nhật phương thức createProduct
  public function createProduct($name, $description, $categoryId, $imageNames) {
    // Kiểm tra category_id
    $sql = "SELECT COUNT(*) FROM categories WHERE category_id = :category_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->fetchColumn() == 0) {
        throw new Exception("Invalid category_id: No matching category found.");
    }

    // Chuyển mảng tên hình ảnh thành chuỗi phân cách bằng dấu phẩy
    $images = implode(',', $imageNames);

    try {
        // Thực hiện truy vấn chèn sản phẩm
        $sql = "INSERT INTO products (name, description, category_id, images) VALUES (:name, :description, :category_id, :images)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':images', $images);
        $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error inserting product: " . $e->getMessage());
    }
}

// Cập nhật phương thức updateProduct
public function updateProduct($id, $name, $description, $categoryId, $imageNames) {
    $images = implode(',', $imageNames); // Chuyển mảng tên hình ảnh thành chuỗi

    $sql = "UPDATE products SET name = ?, description = ?, category_id = ?, images = ? WHERE idProduct = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$name, $description, $categoryId, $images, $id]);
}

// Cập nhật phương thức uploadImages
public function uploadImages($files) {
    $imageNames = [];
    $targetDir = "uploads/";
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp']; // Các loại file được phép

    foreach ($files["name"] as $key => $name) {
        $fileType = mime_content_type($files["tmp_name"][$key]); // Lấy loại file

        // Kiểm tra xem loại file có nằm trong danh sách cho phép không
        if (in_array($fileType, $allowedTypes)) {
            $targetFile = $targetDir . basename($name);

            // Kiểm tra xem file có được tải lên thành công không
            if (move_uploaded_file($files["tmp_name"][$key], $targetFile)) {
                $imageNames[] = $name; // Thêm tên file vào mảng
            }
        } else {
            echo "File {$name} không phải là định dạng hình ảnh hợp lệ."; // Thông báo nếu định dạng không hợp lệ
        }
    }

    return $imageNames; // Trả về mảng tên hình ảnh
}


    
    
    
    // Xóa sản phẩm
    public function deleteProduct($idProduct)
    {
        $stmt = $this->conn->prepare("DELETE FROM product_images WHERE product_id = ?");
        $stmt->execute([$idProduct]);

        $stmt = $this->conn->prepare("DELETE FROM products WHERE idProduct = ?");
        $stmt->execute([$idProduct]);
    }
    public function countProducts() {
        $sql = "SELECT COUNT(idProduct) AS total FROM products"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }
    
} 
