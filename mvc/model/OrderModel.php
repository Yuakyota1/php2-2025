<?php
require_once "Database.php";

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getAllOrders() {
        $query = "SELECT * FROM orders ORDER BY created_at DESC"; // Lấy tất cả đơn hàng sắp xếp theo ngày tạo
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về dữ liệu đơn hàng dưới dạng mảng
    }
    public function getOrderItems($orderId) {
        $query = "SELECT oi.*, p.name AS product_name
                  FROM order_items oi
                  INNER JOIN products p ON oi.product_id = p.idProduct
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về mảng chi tiết sản phẩm trong đơn hàng, bao gồm tên sản phẩm
    }
    // Phương thức lấy đơn hàng theo ID
    public function getOrderById($orderId) {
        $query = "SELECT * FROM orders WHERE id = :orderId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về đơn hàng với email
    }
    public function getOrdersByUserId($user_id) {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
public function deleteOrder($orderId) {
    $sql = "DELETE FROM orders WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
    return $stmt->execute();
}
public function userdelete($orderId) {
    
    $sql = "DELETE FROM orders WHERE id = :id AND status = 'Hủy'";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
    return $stmt->execute();
}
public function getOrderByCode($orderCode) {
    $query = "SELECT * FROM orders WHERE orderCode = :orderCode";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':orderCode', $orderCode, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function updateOrderStatus($orderId, $status) {
    $query = "UPDATE orders SET status = :status WHERE id = :orderId";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':orderId', $orderId);
    return $stmt->execute();
}

public function updateProductQuantity($product_id, $quantity) {
    $sql = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        ':quantity' => $quantity,
        ':product_id' => $product_id
    ]);
}

    
    // Get all orders
    public function getOrders() {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get orders by user_id
    public function getOrderByUserId($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create an order detail
    public function createOrderDetail($order_id, $product_id, $size, $color, $quantity, $price) {
        $total = $price * $quantity;
        
        $query = "INSERT INTO order_items (order_id, product_id, size, color, quantity, price, total, created_at, updated_at)
                  VALUES (:order_id, :product_id, :size, :color, :quantity, :price, :total, :created_at, :updated_at)";
        $stmt = $this->conn->prepare($query);
        
        $date = date('Y-m-d H:i:s');
        
        // Bind parameters
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id); // Đổi từ idProduct thành product_id
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':created_at', $date);
        $stmt->bindParam(':updated_at', $date);
        
        return $stmt->execute();
    }
    

    
    public function createOrder($user_id, $orderCode, $name, $phone, $total_price, $address, $email, $status, $paymentMethod, $carts) {
        // Câu lệnh INSERT vào bảng orders, đã bao gồm email
        $query = "INSERT INTO orders (user_id, email, orderCode, name, address, phone, total_price, payment_method, status, created_at, updated_at)
        VALUES (:user_id, :email, :orderCode, :name, :address, :phone, :total_price, :payment_method, :status, :created_at, :updated_at)";

        
        $stmt = $this->conn->prepare($query);
        
        $date = date('Y-m-d H:i:s');
        
        // Bind các tham số bao gồm email
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':orderCode', $orderCode);
        $stmt->bindParam(':email', $email); // Lưu email vào bảng orders
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_at', $date);
        $stmt->bindParam(':updated_at', $date);
        
        $stmt->execute();
        
        $order_id = $this->conn->lastInsertId();
    
        // Thêm chi tiết các sản phẩm trong giỏ hàng
        foreach ($carts as $cart) {
            $product_id = $cart['product_id'] ?? null; 
            if (!$product_id) {
                die("Lỗi: Không tìm thấy product_id trong giỏ hàng!");
            }
            $this->createOrderDetail($order_id, $product_id, $cart['size'], $cart['color'], $cart['quantity'], $cart['price']);
        }
    
        return true;
    }
    
    
    public function getRevenueByDay() {
        $sql = "
            SELECT DATE(created_at) AS date, COUNT(*) AS total_orders, SUM(total_price) AS total_revenue
            FROM orders
            GROUP BY DATE(created_at)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getRevenueByMonth() {
        $sql = "
            SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, SUM(total_price) AS total_revenue
            FROM orders
            WHERE created_at IS NOT NULL
            GROUP BY YEAR(created_at), MONTH(created_at)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRevenueByYear() {
        $sql = "
            SELECT YEAR(created_at) AS year, SUM(total_price) AS total_revenue
            FROM orders
            WHERE created_at IS NOT NULL
            GROUP BY YEAR(created_at)
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countOrders() {
        $sql = "SELECT COUNT(id) AS total_orders FROM orders";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC)['total_orders'];
    }
}
