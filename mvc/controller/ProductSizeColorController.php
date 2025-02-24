<?php
require_once "model/ProductSizeColorModel.php";
require_once "view/helpers.php";

class ProductSizeColorController {
    private $productSizeColorModel;

    public function __construct() {
        $this->productSizeColorModel = new ProductSizeColorModel();
    }

    public function index() {
        $productSizeColors = $this->productSizeColorModel->getAllProductSizeColors();
        renderView("view/admin/product_size_color_list.php", compact('productSizeColors'), "Product Size Color List");
    }

    public function show($id) {
        $productSizeColor = $this->productSizeColorModel->getProductSizeColorById($id);
        renderView("view/admin/product_size_color_detail.php", compact('productSizeColor'), "Product Size Color Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduct = trim($_POST['idProduct']);
            $color = trim($_POST['color']);
            $idSize = trim($_POST['idSize']);
            $quantity = trim($_POST['quantity']);
            $price = trim($_POST['price']);

            // Xử lý hình ảnh
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $image = $this->uploadImage($_FILES['image']);
                if (!$image) {
                    $errors[] = "Tải hình ảnh thất bại.";
                }
            }

            $errors = [];
            if (empty($idProduct)) $errors[] = "Sản phẩm không được để trống.";
            if (empty($color)) $errors[] = "Màu sắc không được để trống.";
            if (empty($idSize)) $errors[] = "Kích thước không được để trống.";
            if (empty($quantity) || !is_numeric($quantity)) $errors[] = "Số lượng phải là số và không được để trống.";
            if (empty($price) || !is_numeric($price)) $errors[] = "Giá phải là số và không được để trống.";

            if ($this->productSizeColorModel->isColorExists($idProduct, $color, $idSize)) {
                $errors[] = "Sản phẩm với màu sắc và kích thước này đã tồn tại.";
            }

            if (!empty($errors)) {
                $products = $this->productSizeColorModel->getProducts();
                $sizes = $this->productSizeColorModel->getSizes();
                renderView("view/admin/product_size_color_create.php", compact('products', 'sizes', 'errors'), "Create Product Size Color");
                return;
            }

            $this->productSizeColorModel->createProductSizeColor($idProduct, $color, $idSize, $quantity, $price, $image);
            header("Location: /admin/product_size_color");
        } else {
            $products = $this->productSizeColorModel->getProducts();
            $sizes = $this->productSizeColorModel->getSizes();
            renderView("view/admin/product_size_color_create.php", compact('products', 'sizes'), "Create Product Size Color");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduct = trim($_POST['idProduct']);
            $color = trim($_POST['color']);
            $idSize = trim($_POST['idSize']);
            $quantity = trim($_POST['quantity']);
            $price = trim($_POST['price']);

            // Xử lý hình ảnh
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $image = $this->uploadImage($_FILES['image']);
                if (!$image) {
                    $errors[] = "Tải hình ảnh thất bại.";
                }
            }

            $errors = [];
            if (empty($idProduct)) $errors[] = "Sản phẩm không được để trống.";
            if (empty($color)) $errors[] = "Màu sắc không được để trống.";
            if (empty($idSize)) $errors[] = "Kích thước không được để trống.";
            if (empty($quantity) || !is_numeric($quantity)) $errors[] = "Số lượng phải là số và không được để trống.";
            if (empty($price) || !is_numeric($price)) $errors[] = "Giá phải là số và không được để trống.";

            if (!empty($errors)) {
                $productSizeColor = $this->productSizeColorModel->getProductSizeColorById($id);
                $products = $this->productSizeColorModel->getProducts();
                $sizes = $this->productSizeColorModel->getSizes();
                renderView("view/admin/product_size_color_edit.php", compact('productSizeColor', 'products', 'sizes', 'errors'), "Edit Product Size Color");
                return;
            }

            $this->productSizeColorModel->updateProductSizeColor($id, $idProduct, $color, $idSize, $quantity, $price, $image);
            header("Location: /admin/product_size_color");
        } else {
            $productSizeColor = $this->productSizeColorModel->getProductSizeColorById($id);
            $products = $this->productSizeColorModel->getProducts();
            $sizes = $this->productSizeColorModel->getSizes();
            renderView("view/admin/product_size_color_edit.php", compact('productSizeColor', 'products', 'sizes'), "Edit Product Size Color");
        }
    }

    public function delete($id) {
        $this->productSizeColorModel->deleteProductSizeColor($id);
        header("Location: /admin/product_size_color");
    }

    private function uploadImage($file) {
        $targetDir = "uploads/";
        $fileName = basename($file["name"]);
        $targetFilePath = $targetDir . uniqid() . "_" . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                return $targetFilePath;
            }
        }
        return false;
    }
}
