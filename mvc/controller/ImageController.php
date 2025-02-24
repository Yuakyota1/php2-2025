<?php
require_once "model/ImageModel.php";
require_once "view/helpers.php";

class ImageController {
    private $imageModel;

    public function __construct() {
        $this->imageModel = new ImageModel();
    }

    public function index() {
        $images = $this->imageModel->getAllImages();
        renderView("view/admin/images_list.php", compact('images'), "Images List");
    }

    public function show($image_id) {
        $image = $this->imageModel->getImageById($image_id);
        renderView("view/admin/images_detail.php", compact('image'), "Image Detail");
    }

    public function upload() {
        // Tạm thời thay đổi cấu hình upload
        ini_set('upload_max_filesize', '10M');
        ini_set('post_max_size', '20M');
        ini_set('max_file_uploads', 50);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = $_FILES['image']['name'];
                $fileSize = $_FILES['image']['size'];
                $fileType = $_FILES['image']['type'];

                // Lấy phần mở rộng của tệp
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Kiểm tra định dạng tệp
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo "Invalid file type. Only JPG, PNG, and WebP files are allowed.";
                    return;
                }

                // Kiểm tra kiểu MIME của tệp
                if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/webp'])) {
                    echo "Invalid file type. Only JPG, PNG, and WebP files are allowed.";
                    return;
                }

                // Kiểm tra kích thước tệp (tùy chỉnh, ví dụ tối đa 10MB)
                if ($fileSize > 10 * 1024 * 1024) {
                    echo "File size is too large. Maximum allowed size is 10MB.";
                    return;
                }

                // Đặt thư mục upload và chuyển tệp
                $uploadDir = 'uploads/';
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($fileTmpPath, $filePath)) {
                    // Lưu thông tin vào cơ sở dữ liệu
                    $this->imageModel->createImage($fileName, $filePath);
                    header("Location: /admin/images");
                } else {
                    echo "Failed to upload image.";
                }
            } else {
                echo "No file uploaded or upload error occurred.";
            }
        } else {
            renderView("view/admin/images_upload.php", [], "Upload Image");
        }
    }
    
    public function edit($image_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];

            // Cập nhật thông tin ảnh
            $this->imageModel->updateImage($image_id, $name); 
            header("Location: /admin/images");
        } else {
            $image = $this->imageModel->getImageById($image_id);
            renderView("view/admin/images_edit.php", compact('image'), "Edit Image");
        }
    }

    public function delete($image_id) {
        $this->imageModel->deleteImage($image_id);
        header("Location: /admin/images");
    }
}
?>
