<?php
require_once "model/OrderModel.php";
require_once "model/ProductModel.php";
require_once "view/helpers.php";

class ReportController {
    private $orderModel;
    private $productModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        // Lấy thống kê doanh thu
        $revenueByDay = $this->orderModel->getRevenueByDay();
        $revenueByMonth = $this->orderModel->getRevenueByMonth();
        $revenueByYear = $this->orderModel->getRevenueByYear();

        // Lấy số lượng sản phẩm
        $totalProducts = $this->productModel->countProducts();

        // Lấy tổng số đơn hàng
        $totalOrders = $this->orderModel->countOrders();

        // Hiển thị báo cáo trong admin
        renderView("view/admin/report_dashboard.php", compact('revenueByDay', 'revenueByMonth', 'revenueByYear', 'totalProducts', 'totalOrders'), "Báo cáo thống kê");
    }
}
