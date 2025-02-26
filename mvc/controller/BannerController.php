<?php
require_once "model/BannerModel.php";
require_once "view/helpers.php";

class BannerController {
    private $bannerModel;

    public function __construct() {
        $this->bannerModel = new BannerModel();
    }

    public function index() {
        $banners = $this->bannerModel->getAllBanners();
        renderView("view/admin/banner/banners_list.php", compact('banners'), "Banner List");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);

            // Kiểm tra file upload
            if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
                $error = "Vui lòng chọn ảnh hợp lệ.";
                renderView("view/admin/banners_create.php", compact('error'), "Create Banner");
                return;
            }

            // Lưu ảnh
            $uploadDir = "uploads/banners/";
            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $error = "Không thể tải ảnh lên.";
                renderView("view/admin/banners_create.php", compact('error'), "Create Banner");
                return;
            }

            // Lưu banner vào DB
            $this->bannerModel->createBanner($title, $imageName);
            header("Location: /admin/banners");
        } else {
            renderView("view/admin/banner/banners_create.php", [], "Create Banner");
        }
    }

    public function edit($banner_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $banner = $this->bannerModel->getBannerById($banner_id);
            $imageName = $banner['image']; // Giữ ảnh cũ nếu không có ảnh mới

            // Kiểm tra nếu có ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = "uploads/banners/";
                $imageName = time() . "_" . basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $imageName;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $error = "Không thể tải ảnh lên.";
                    renderView("view/admin/banners_edit.php", compact('error', 'banner'), "Edit Banner");
                    return;
                }
            }

            // Cập nhật banner
            $this->bannerModel->updateBanner($banner_id, $title, $imageName);
            header("Location: /admin/banner/banners");
        } else {
            $banner = $this->bannerModel->getBannerById($banner_id);
            renderView("view/admin/banner/banners_edit.php", compact('banner'), "Edit Banner");
        }
    }

    public function delete($banner_id) {
        $banner = $this->bannerModel->getBannerById($banner_id);
        if ($banner && file_exists("uploads/banners/" . $banner['image'])) {
            unlink("uploads/banners/" . $banner['image']); // Xóa ảnh
        }

        $this->bannerModel->deleteBanner($banner_id);
        header("Location: /admin/banner/banners");
    }
}
