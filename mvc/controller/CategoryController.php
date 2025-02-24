<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        renderView("view/admin/categories_list.php", compact('categories'), "Categories List");
    }

    public function show($category_id) {
        $category = $this->categoryModel->getCategoryById($category_id);
        renderView("view/admin/categories_detail.php", compact('category'), "Category Detail");
    }
    

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = trim($_POST['category_name']); // Xóa khoảng trắng thừa

            // Validate dữ liệu
            if (empty($category_name)) {
                $error = "Tên danh mục không được để trống.";
                renderView("view/admin/categories_create.php", compact('error'), "Create Category");
                return;
            }

            // Lưu danh mục sau khi validate thành công
            $this->categoryModel->createCategory($category_name);
            header("Location: /admin/categories");
        } else {
            renderView("view/admin/categories_create.php", [], "Create Category");
        }
    }

    public function edit($category_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = trim($_POST['category_name']); // Xóa khoảng trắng thừa

            // Validate dữ liệu
            if (empty($category_name)) {
                $error = "Tên danh mục không được để trống.";
                $category = $this->categoryModel->getCategoryById($category_id);
                renderView("view/admin/categories_edit.php", compact('error', 'category'), "Edit Category");
                return;
            }

            // Cập nhật danh mục sau khi validate thành công
            $this->categoryModel->updateCategory($category_id, $category_name);
            header("Location: /admin/categories");
        } else {
            $category = $this->categoryModel->getCategoryById($category_id);
            renderView("view/admin/categories_edit.php", compact('category'), "Edit Category");
        }
    }

    public function delete($category_id) {
        $this->categoryModel->deleteCategory($category_id);
        header("Location: /admin/categories");
    }
}
