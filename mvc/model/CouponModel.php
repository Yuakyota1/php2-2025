<?php
require_once "Database.php";

class CouponModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCoupons() {
        $query = "SELECT * FROM coupons";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCouponById($coupon_id) {
        $query = "SELECT * FROM coupons WHERE coupon_id = :coupon_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':coupon_id', $coupon_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCoupon($coupon_code, $discount, $expiry_date = null) {
        $query = "INSERT INTO coupons (coupon_code, discount, expired_at) 
                  VALUES (:coupon_code, :discount, :expired_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':coupon_code', $coupon_code);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':expired_at', $expiry_date); // Thêm ngày hết hạn
    
        return $stmt->execute();
    }
    

    public function updateCoupon($coupon_id, $coupon_code, $discount) {
        $query = "UPDATE coupons SET coupon_code = :coupon_code, discount = :discount WHERE coupon_id = :coupon_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':coupon_id', $coupon_id);
        $stmt->bindParam(':coupon_code', $coupon_code);
        $stmt->bindParam(':discount', $discount);
        return $stmt->execute();
    }

    public function deleteCoupon($coupon_id) {
        $query = "DELETE FROM coupons WHERE coupon_id = :coupon_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':coupon_id', $coupon_id);
        return $stmt->execute();
    }
}
