<?php
require_once "Database.php";

class CartModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy giỏ hàng theo user_id hoặc session_id
    public function getCart($user_id, $session_id) {
        $condition = !empty($user_id) ? "user_id = :user_id" : "cart_session = :cart_session";
        
        $query = "SELECT * FROM carts WHERE $condition";
        $stmt = $this->conn->prepare($query);
        if (!empty($user_id)) {
            $stmt->bindParam(':user_id', $user_id);
        } else {
            $stmt->bindParam(':cart_session', $session_id);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCartItemsByOrder($order_id) {
        $query = "SELECT p.name AS product_name, oi.price, oi.quantity 
                  FROM order_items oi
                  JOIN products p ON oi.product_id = p.idProduct
                  WHERE oi.order_id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Thêm sản phẩm vào giỏ hàng
    public function addCart($user_id, $cart_session, $product_id, $name, $quantity, $price, $total_price, $color, $size, $image) {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $query = "SELECT id, quantity FROM carts WHERE product_id = :product_id AND color = :color AND size = :size AND (user_id = :user_id OR cart_session = :cart_session)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':cart_session', $cart_session);
        $stmt->execute();
        $existingCart = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existingCart) {
            // Nếu sản phẩm đã có, cập nhật số lượng và tổng tiền
            $newQuantity = $existingCart['quantity'] + $quantity;
            $query = "UPDATE carts SET quantity = :quantity, total_price = price * :quantity WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->bindParam(':id', $existingCart['id']);
            return $stmt->execute();
        } else {
            // Nếu sản phẩm chưa có, thêm mới
            $query = "INSERT INTO carts (user_id, cart_session, product_id, name, quantity, price, total_price, color, size, image) 
                      VALUES (:user_id, :cart_session, :product_id, :name, :quantity, :price, :total_price, :color, :size, :image)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':cart_session', $cart_session);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':total_price', $total_price);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':image', $image);
            return $stmt->execute();
        }
    }
    public function getCartById($id) {
        $sql = "SELECT * FROM carts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getQuantityById($idProduct, $color, $idSize) {
        $sql = "SELECT quantity FROM product_size_color WHERE idProduct = ? AND color = ? AND idSize = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idProduct, $color, $idSize]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? (int) $result['quantity'] : 0;
    }
    

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCart($id) {
        $query = "DELETE FROM carts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
 // Xóa toàn bộ giỏ hàng theo user_id hoặc session_id
 public function clearCart($user_id, $session_id) {
    $condition = !empty($user_id) ? "user_id = :user_id" : "cart_session = :cart_session";

    $query = "DELETE FROM carts WHERE $condition";
    $stmt = $this->conn->prepare($query);
    if (!empty($user_id)) {
        $stmt->bindParam(':user_id', $user_id);
    } else {
        $stmt->bindParam(':cart_session', $session_id);
    }
    return $stmt->execute();
}
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateQuantity($id, $quantity) {
        $query = "UPDATE carts SET quantity = :quantity, total_price = price * :quantity WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

?>
