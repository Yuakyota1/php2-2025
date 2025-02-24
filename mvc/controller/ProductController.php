<?php
require_once "model/CategoryModel.php";  // Thêm dòng này
require_once "model/ProductModel.php";
require_once "model/ImageModel.php";

class ProductController {
    private $productModel;
    private $imageModel;
    private $categoryModel; // Khai báo categoryModel

    public function __construct() {
        $this->productModel = new ProductModel();

        $this->categoryModel = new CategoryModel(); // Khởi tạo CategoryModel
        
        
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        
        // Lấy hình ảnh cho mỗi sản phẩm
        foreach ($products as &$product) {
            $product['images'] = $this->productModel->getImagesByProductId($product['idProduct']); // Lấy hình ảnh cho sản phẩm
        }
    
        renderView("view/admin/product_list.php", compact('products'), "Product List");
    }
    
    

    public function show($id) {
        $product = $this->productModel->getProductById($id);
        
        // Lấy hình ảnh cho sản phẩm
        $product['images'] = $this->productModel->getImagesByProductId($id);
        
        $product['sizeColors'] = $this->productModel->getSizeColorsByProductId($id);  // Lấy tên size
    
        renderView("view/admin/product_detail.php", compact('product'), "Product Detail");
    }
    
    public function detail($id) {
        $product = $this->productModel->getProductById($id);
    
        // Lấy hình ảnh và các tùy chọn của sản phẩm
        $product['images'] = $this->productModel->getImagesByProductId($id);
        $product['sizeColors'] = $this->productModel->getSizeColorsByProductId($id);
    
        // Lấy danh sách sản phẩm liên quan (cùng danh mục, loại trừ sản phẩm hiện tại)
        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id);
    
        renderView("view/product_detail.php", compact('product', 'relatedProducts'), "Product Detail");
    }
    
    
    public function list() {
        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
        
        if ($categoryId) {
            $products = $this->productModel->getProductsByCategory($categoryId);
        } else {
            $products = $this->productModel->getAllProducts();
        }
    
        $categories = $this->categoryModel->getAllCategories();
    
        foreach ($products as &$product) {
            $product['images'] = $this->productModel->getImagesByProductId($product['idProduct']);
            $product['sizeColors'] = $this->productModel->getSizeColorsByProductId($product['idProduct']);
        }
    
        renderView("view/home.php", compact('products', 'categories', 'categoryId'), "Product List");
    }
    
    
    
    public function shop() {
        $categoryId = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? '';
    
        // Lọc theo danh mục
        if ($categoryId) {
            $products = $this->productModel->getProductsByCategory($categoryId);
        } else {
            $products = $this->productModel->getAllProducts();
        }
    
        // Kiểm tra mảng products
        if (!is_array($products)) {
            $products = [];
        }
    
        // Lọc theo tìm kiếm
        if (!empty($search)) {
            $products = array_filter($products, function($product) use ($search) {
                return stripos($product['name'], $search) !== false;
            });
        }
    
        // Sắp xếp theo giá
        if (!empty($sort)) {
            usort($products, function($a, $b) use ($sort) {
                return ($sort === 'asc') ? ($a['price'] - $b['price']) : ($b['price'] - $a['price']);
            });
        }
    
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAllCategories();
    
        // Lấy ảnh và size/color cho mỗi sản phẩm
        foreach ($products as &$product) {
            $product['images'] = $this->productModel->getImagesByProductId($product['idProduct']) ?? [];
            $product['sizeColors'] = $this->productModel->getSizeColorsByProductId($product['idProduct']) ?? [];
        }
    
        // Truyền dữ liệu sang view
        renderView("view/shop.php", compact('categories', 'products'));
    }
    
    
    
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $categoryId = $_POST['category_id'];
    
            // Tải lên hình ảnh
            $imageNames = $this->productModel->uploadImages($_FILES['images']); // Tải lên tất cả hình ảnh
            
            try {
                if (!empty($imageNames)) { // Kiểm tra xem có hình ảnh nào được tải lên không
                    $this->productModel->createProduct($name, $description, $categoryId, $imageNames);
                    header("Location: /admin/products");
                } else {
                    echo "Không có hình ảnh nào được tải lên.";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    
        // Lấy danh mục để hiển thị trong form tạo sản phẩm
        $categories = $this->categoryModel->getAllCategories();
        renderView("view/admin/product_create.php", compact('categories'), "Create Product");
    }
    
    
     public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $categoryId = $_POST['category_id'];
            $imageIds = [];
    
            // Xử lý hình ảnh
            if (isset($_FILES['images'])) {
                foreach ($_FILES['images']['name'] as $key => $imageName) {
                    $imageId = $this->productModel->uploadImages($_FILES['images'][$key]);
                    if ($imageId) {
                        $imageIds[] = $imageId;
                    }
                }
            }
    
            // Cập nhật sản phẩm
            $this->productModel->updateProduct($id, $name, $description, $categoryId, $imageIds);
            header("Location: /admin/products");
        } else {
            // Lấy sản phẩm và danh mục
            $product = $this->productModel->getProductById($id);
            $categories = $this->categoryModel->getAllCategories(); // Lấy danh sách danh mục
    
            renderView("view/admin/product_edit.php", compact('product', 'categories'), "Edit Product");
        }
    }
    
    
    public function delete($idProduct) {
        $this->productModel->deleteProduct($idProduct);
        header("Location: /admin/products");
    }
}
