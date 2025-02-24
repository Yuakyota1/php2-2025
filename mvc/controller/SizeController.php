<?php
require_once "model/SizeModel.php";
require_once "view/helpers.php";

class SizeController {
    private $sizeModel;

    public function __construct() {
        $this->sizeModel = new SizeModel();
    }

    public function index() {
        $sizes = $this->sizeModel->getAllSizes();
        renderView("view/admin/size_list.php", compact('sizes'), "Size List");
    }

    public function show($id) {
        $size = $this->sizeModel->getSizeById($id);
        renderView("view/admin/size_detail.php", compact('size'), "Size Detail");
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameSize = trim($_POST['nameSize']);
    
            if (empty($nameSize)) {
                $error = "Tên size không được để trống.";
                renderView("view/admin/size_create.php", compact('error'), "Create Size");
                return;
            }
    
            // Kiểm tra trùng tên size
            if ($this->sizeModel->isSizeNameExists($nameSize)) {
                $error = "Tên size đã tồn tại. Vui lòng chọn tên khác.";
                renderView("view/admin/size_create.php", compact('error'), "Create Size");
                return;
            }
    
            $this->sizeModel->createSize($nameSize);
            header("Location: /admin/sizes");
        } else {
            renderView("view/admin/size_create.php", [], "Create Size");
        }
    }
    

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameSize = trim($_POST['nameSize']);
    
            if (empty($nameSize)) {
                $error = "Tên size không được để trống.";
                $size = $this->sizeModel->getSizeById($id);
                renderView("view/admin/size_edit.php", compact('error', 'size'), "Edit Size");
                return;
            }
    
            if ($this->sizeModel->isSizeNameExists($nameSize, $id)) {
                $error = "Tên size đã tồn tại. Vui lòng chọn tên khác.";
                $size = $this->sizeModel->getSizeById($id);
                renderView("view/admin/size_edit.php", compact('error', 'size'), "Edit Size");
                return;
            }
    
            $this->sizeModel->updateSize($id, $nameSize);
            header("Location: /admin/sizes");
        } else {
            $size = $this->sizeModel->getSizeById($id);
            renderView("view/admin/size_edit.php", compact('size'), "Edit Size");
        }
    }
    

    public function delete($id) {
        $this->sizeModel->deleteSize($id);
        header("Location: /admin/sizes");
    }
}
