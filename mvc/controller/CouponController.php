<?php
require_once "model/CouponModel.php";
require_once "view/helpers.php";

class CouponController {
    private $couponModel;

    public function __construct() {
        $this->couponModel = new CouponModel();
    }

    public function index() {
        $coupons = $this->couponModel->getAllCoupons();
        renderView("view/admin/coupon/coupons_list.php", compact('coupons'), "Coupons List");
    }

    public function show($coupon_id) {
        $coupon = $this->couponModel->getCouponById($coupon_id);
        renderView("view/admin/coupon/coupons_detail.php", compact('coupon'), "Coupon Detail");
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $coupon_code = trim($_POST['coupon_code']);
            $discount = floatval($_POST['discount']);
            $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : null;
    
            if (empty($coupon_code) || $discount <= 0) {
                $error = "Mã coupon và mức giảm giá không hợp lệ.";
                renderView("view/admin/coupon/coupons_create.php", compact('error'), "Create Coupon");
                return;
            }
    
            $this->couponModel->createCoupon($coupon_code, $discount, $expiry_date);
            header("Location: /admin/coupons");
        } else {
            renderView("view/admin/coupon/coupons_create.php", [], "Create Coupon");
        }
    }


    public function edit($coupon_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $coupon_code = trim($_POST['coupon_code']);
            $discount = floatval($_POST['discount']);
            
            // Validate dữ liệu
            if (empty($coupon_code) || $discount <= 0) {
                $error = "Mã coupon và mức giảm giá không hợp lệ.";
                $coupon = $this->couponModel->getCouponById($coupon_id);
                renderView("view/admin/coupon/coupons_edit.php", compact('error', 'coupon'), "Edit Coupon");
                return;
            }
            
            // Cập nhật coupon sau khi validate thành công
            $this->couponModel->updateCoupon($coupon_id, $coupon_code, $discount);
            header("Location: /admin/coupons");
        } else {
            $coupon = $this->couponModel->getCouponById($coupon_id);
            renderView("view/admin/coupon/coupons_edit.php", compact('coupon'), "Edit Coupon");
        }
    }

    public function delete($coupon_id) {
        $this->couponModel->deleteCoupon($coupon_id);
        header("Location: /admin/coupons");
    }
}
