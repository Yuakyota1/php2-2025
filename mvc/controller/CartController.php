<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once "model/CategoryModel.php";
require_once "view/helpers.php";
require_once "model/CartModel.php";
require_once 'model/OrderModel.php';

class CartController {
    private $cartModel;

    private $orderModel;
    public function __construct() {
        $this->cartModel = new CartModel();
        $this->orderModel = new OrderModel();
        
    }

    public function index() {
        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);
        //compact: gom bien dien thanh array
        renderView("view/cart/list.php", compact('carts'), "carts List");
    }

    public function list() {
        // Gọi model OrderModel để lấy danh sách đơn hàng
        $orders = $this->orderModel->getAllOrders(); // Giả sử phương thức này lấy tất cả đơn hàng
        
        renderView("view/admin/orders_list.php", compact('orders'), "orders Detail");
    }
   // Cập nhật trạng thái đơn hàng trong phần xử lý POST
   public function edit($orderId) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $orderId = $_POST['id']; // Lấy id từ form
        $status = $_POST['status']; // Lấy trạng thái mới từ form

        // Validate dữ liệu
        if (empty($orderId) || empty($status)) {
            $error = "ID đơn hàng và trạng thái không được để trống!";
            $order = $this->orderModel->getOrderById($orderId); // Lấy thông tin đơn hàng
            renderView("view/admin/orders_edit.php", compact('error', 'order'), "Edit Order");
            return;
        }

        // Cập nhật trạng thái đơn hàng
        $this->orderModel->updateOrderStatus($orderId, $status);

        // Lấy thông tin đơn hàng sau khi cập nhật
        $order = $this->orderModel->getOrderById($orderId);

        // Gửi email thông báo về trạng thái mới
        $this->sendOrderStatusUpdateEmail($order['email'], $order['name'], $status , $order['orderCode']);

        header("Location: /admin/orders"); // Sau khi cập nhật, chuyển hướng đến danh sách đơn hàng
    } else {
        $order = $this->orderModel->getOrderById($orderId); // Lấy thông tin đơn hàng theo ID
        renderView("view/admin/orders_edit.php", compact('order'), "Edit Order");
    }
}
private function sendOrderStatusUpdateEmail($email, $name, $status, $orderCode) {
    // Khởi tạo PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Cấu hình SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'adsasiki777@gmail.com';  // Thay bằng email của bạn
        $mail->Password = 'akhh ibru frvw xfza';  // Thay bằng mật khẩu của bạn
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet = 'UTF-8';
        // Thiết lập người nhận và người gửi
        $mail->setFrom('adminshop@gmail.com', 'yuyushop');
        $mail->addAddress($email, $name, $orderCode);  // Gửi email đến khách hàng

        // Tiêu đề email
        $mail->Subject = 'Cập Nhật Trạng Thái Đơn Hàng';

        // Nội dung email
        $bodyContent = "<h2>Chào " . $name . ",</h2>";
        $bodyContent ="<p>Mã đơn hàng " . $orderCode . ",</p>";
        $bodyContent .= "<p>Trạng thái đơn hàng của bạn đã được cập nhật thành: <strong>" . $status . "</strong></p>";
        $bodyContent .= "<p>Chúng tôi sẽ thông báo thêm khi đơn hàng của bạn được xử lý tiếp theo.</p>";
        
        // Set content
        $mail->isHTML(true);
        $mail->Body = $bodyContent;

        // Gửi email
        $mail->send();
    } catch (Exception $e) {
        echo "Lỗi khi gửi email: " . $mail->ErrorInfo;
    }
}

    
    
    

    public function show($orderId) {
        $order_items = $this->orderModel->getOrderItems($orderId); // Lấy chi tiết đơn hàng từ model
        renderView("view/admin/orders_detail.php", compact('order_items'), "Chi Tiết Đơn Hàng");

    }
    public function userOrders() {
        $user_id = $_SESSION['user']['id'] ?? null;
    
        if (!$user_id) {
            $_SESSION['error_message'] = "Bạn cần đăng nhập để xem đơn hàng!";
            header("Location: /login");
            exit;
        }
    
        $orders = $this->orderModel->getOrdersByUserId($user_id); // Lấy đơn hàng theo user_id
        renderView("view/order.php", compact('orders'), "Danh sách đơn hàng của bạn");
    }
    public function orderDetail($orderId) {
        $user_id = $_SESSION['user']['id'] ?? null;
    
        if (!$user_id) {
            $_SESSION['error_message'] = "Bạn cần đăng nhập để xem đơn hàng!";
            header("Location: /login");
            exit;
        }
    
        $order = $this->orderModel->getOrderById($orderId);
    
        if (!$order || $order['user_id'] != $user_id) {
            die("Đơn hàng không tồn tại hoặc bạn không có quyền xem!");
        }
    
        $order_items = $this->orderModel->getOrderItems($orderId);
        renderView("view/order_detail.php", compact('order', 'order_items'), "Chi tiết đơn hàng");
    }
    
public $vnp_TmnCode = "YYW4FSIN";
public $vnp_HashSecret = "PFLZG36HZT953580CDM4I6NR6VM5KTD2";
public $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
public $vnp_Returnurl = "http://localhost:8000/vnpay_return"; // Đường dẫn nhận kết quả thanh toán

public function checkout() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $note = $_POST['note'];
        $payment = $_POST['payment'];

        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);

        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['price'] * $cart['quantity'];
        }

        $orderCode = uniqid(); // Mã đơn hàng
        $status = 'Chờ xử lý';

        // Tạo đơn hàng trước khi thanh toán
        $isCreate = $this->orderModel->createOrder(
            $user_id, $orderCode, $name, $phone, $total, $address, 
            $email, $status, $payment, $carts
        );

        if (!$isCreate) {
            $_SESSION['error_message'] = "Không thể tạo đơn hàng!";
            header("Location: /checkout");
            exit;
        }

        if ($payment === 'vnpay') {
            $vnp_Amount = $total * 100; // VNPAY yêu cầu đơn vị VND x100
            $vnp_TxnRef = $orderCode;
            $vnp_OrderInfo = "Thanh toán đơn hàng $orderCode";
            $vnp_Locale = "vn";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $this->vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $this->vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            ksort($inputData);
            $query = "";
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                $hashdata .= ($query ? '&' : '') . urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $vnp_Url = $this->vnp_Url . "?" . $query . "vnp_SecureHash=" . $vnpSecureHash;

            header("Location: " . $vnp_Url);
            exit;
        } else {
            $this->sendOrderConfirmationEmail($email, $name, $orderCode, $address, $total, $carts);
            $this->clearCart();
            $_SESSION['message'] = "Đặt hàng thành công!";
            header("Location: /order");
            exit;
        }
    } else {
        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
        $carts = $this->cartModel->getCart($user_id, $session_id);
        renderView("view/cart/checkout.php", compact('carts'), "Checkout");
    }
    
}



public function vnpayReturn() {
    if (!isset($_GET['vnp_SecureHash'])) {
        $_SESSION['error_message'] = "Dữ liệu không hợp lệ!";
        header("Location: /order");
        exit;
    }

    $vnp_HashSecret = "PFLZG36HZT953580CDM4I6NR6VM5KTD2";
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    unset($_GET['vnp_SecureHash']);

    ksort($_GET);
    $hashData = "";
    foreach ($_GET as $key => $value) {
        $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    if ($secureHash === $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] == '00') {
            $_SESSION['message'] = "Thanh toán thành công! Mã đơn hàng: " . $_GET['vnp_TxnRef'];
    
            // Cập nhật trạng thái đơn hàng
            $result = $this->orderModel->updateOrderStatus($_GET['vnp_TxnRef'], 'Chờ Xác Nhận');
    
            if (!$result) {
                die("Lỗi: Không thể cập nhật trạng thái đơn hàng! Kiểm tra orderCode.");
            }
    
            // Lấy thông tin đơn hàng để gửi email
            $order = $this->orderModel->getOrderByCode($_GET['vnp_TxnRef']);
            if ($order) {
                $this->sendOrderConfirmationEmail(
                    $order['email'], 
                    $order['name'], 
                    $order['orderCode'], 
                    $order['address'], 
                    $order['total_price'], 
                    $this->cartModel->getCartItemsByOrder($order['id'])
                );
            }
    
            // Xóa giỏ hàng sau khi thanh toán thành công
            $this->clearCart();
        } else {
            $_SESSION['error_message'] = "Thanh toán thất bại!";
        }
    } else {
        $_SESSION['error_message'] = "Lỗi xác thực thanh toán!";
    }
    
    header("Location: /order");
    exit;    
}



    private function sendOrderConfirmationEmail($email, $name, $orderCode, $address, $total, $carts) {
        // Khởi tạo PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Cấu hình SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'adsasiki777@gmail.com';  // Email gửi
            $mail->Password = 'akhh ibru frvw xfza';  // Mật khẩu email gửi
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
    
            $mail->CharSet = 'UTF-8';
            // Thiết lập người nhận và người gửi
            $mail->setFrom('adminshop@gmail.com', 'yuyushop');
            $mail->addAddress($email, $name);  // Gửi email đến người mua
    
            // Tiêu đề email
            $mail->Subject = 'Đặt hàng thành công - Mã đơn hàng: ' . $orderCode;
    
            // Nội dung email
            $bodyContent = "<h2>Chào " . $name . ",</h2>";
            $bodyContent .= "<p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là thông tin đơn hàng của bạn:</p>";
            $bodyContent .= "<p><strong>Mã đơn hàng:</strong> " . $orderCode . "</p>";
            $bodyContent .= "<p><strong>Tổng tiền:</strong> " . number_format($total, 0, ',', '.') . " VND</p>";
            $bodyContent .= "<p><strong>Chi tiết sản phẩm:</strong></p>";
            $bodyContent .= "<ul>";
    
            foreach ($carts as $cart) {
                $bodyContent .= "<li>" . $cart['name'] . " (x" . $cart['quantity'] . ") - " . number_format($cart['price'], 0, ',', '.') . " VND</li>";
            }
    
            $bodyContent .= "</ul>";
            $bodyContent .= "<p>Địa chỉ giao hàng: " . $address . "</p>";
            $bodyContent .= "<p><strong>Trạng thái đơn hàng:</strong> Đang xử lý</p>";
    
            // Set content
            $mail->isHTML(true);
            $mail->Body = $bodyContent;
    
            // Gửi email
            $mail->send();
        } catch (Exception $e) {
            echo "Lỗi khi gửi email: " . $mail->ErrorInfo;
        }
    }
    
    public function deleteOrder($orderId) {
        // Kiểm tra xem đơn hàng có tồn tại không
        $order = $this->orderModel->getOrderById($orderId);
        
        if (!$order) {
            die("Đơn hàng không tồn tại.");
        }
    
        // Xóa đơn hàng
        $deleted = $this->orderModel->deleteOrder($orderId);
    
        if ($deleted) {
            header("Location: /admin/orders?message=deleted");
            exit;
        } else {
            die("Xóa đơn hàng thất bại.");
        }
    }
    
    public function cancelOrder($orderId) {
        $user_id = $_SESSION['user']['id'] ?? null;
        $order = $this->orderModel->getOrderById($orderId);
    
   if (!$order || $order['user_id'] != $user_id) {
    $_SESSION['error_message'] = "Đơn hàng không tồn tại hoặc bạn không có quyền hủy!";
    echo "<script>alert('Đơn hàng không tồn tại hoặc bạn không có quyền hủy!'); window.location.href='/order';</script>";
    exit;
}

    
        if (strtolower(trim($order['status'])) !== 'chờ xử lý') {
            $_SESSION['error_message'] = "Bạn chỉ có thể hủy đơn hàng khi đơn hàng chưa được xử lý!";
            header("Location: /order");
            exit;
        }
    
        // Cập nhật trạng thái đơn hàng thành 'đã hủy'
        $this->orderModel->updateOrderStatus($orderId, 'Hủy');
    
        $_SESSION['message'] = "Đơn hàng đã được hủy thành công! Bạn có thể đặt lại hoặc xóa đơn hàng.";
        header("Location: /order");
        exit;
    }
    public function userdelete($orderId) {
        $user_id = $_SESSION['user']['id'] ?? null;
        $order = $this->orderModel->getOrderById($orderId);
    
        if (!$order || $order['user_id'] != $user_id || strtolower(trim($order['status'])) !== 'hủy') {
            echo "<script>alert('Bạn chỉ có thể xóa đơn hàng đã hủy!'); window.location.href='/order';</script>";
            exit;
        }
        
    
        // Xóa đơn hàng
        $deleted = $this->orderModel->userdelete($orderId);
        
        if ($deleted) {
            header("Location: /order");
            exit; 
        } else {
            die("Xóa đơn hàng thất bại.");
        }
    }
    
    public function tracking() {
        if (!isset($_GET['order_code']) || empty($_GET['order_code'])) {
            $_SESSION['error_message'] = "Vui lòng nhập mã đơn hàng!";
            renderView("view/tracking.php", [], "Tra Cứu Đơn Hàng"); // Hiển thị trang mà không redirect
            exit;
        }
    
        $orderCode = trim($_GET['order_code']);
        $order = $this->orderModel->getOrderByCode($orderCode);
    
        if (!$order) {
            $_SESSION['error_message'] = "Không tìm thấy đơn hàng!";
            renderView("view/tracking.php", [], "Tra Cứu Đơn Hàng"); // Hiển thị trang mà không redirect
            exit;
        }
    
        // Render giao diện tracking với dữ liệu đơn hàng
        renderView("view/tracking.php", compact('order'), "Tra Cứu Đơn Hàng");
        exit;
    }
    
    
    
    

    // public function show($id) {
    //     $categories = $this->categoryModel->getCategoryById($id);
    //     renderView("view/category_detail.php", compact('categories'), "categories Detail");
    // }
   public function create() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Đảm bảo session hoạt động
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra đăng nhập
        $user_id = $_SESSION['user']['id'] ?? null;
        $cart_session = $user_id ? "user_" . $user_id : session_id(); // Gán session theo user_id nếu có

        // Lấy dữ liệu từ form
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $name = $_POST['name'] ?? 'No Name'; 
        $quantity = max(1, filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT) ?? 1);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $color = $_POST['selected_color'] ?? 'Mặc định';
        $size = $_POST['selected_size'] ?? 'Mặc định';
        $image = $_POST['image'] ?? ''; 

        if (!$product_id || !$price) {
            $_SESSION['error_message'] = "Lỗi: Dữ liệu sản phẩm không hợp lệ.";
            header("Location: /shop");
            exit;
        }

        $total_price = $price * $quantity;

        // Nếu chưa đăng nhập, lưu giỏ hàng vào session
        if (!$user_id) {
            $_SESSION['cart'][$product_id] = [
                'cart_session' => $cart_session,
                'product_id' => $product_id,
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'total_price' => $total_price,
                'color' => $color,
                'size' => $size,
                'image' => $image
            ];
        } else {
            // Nếu đã đăng nhập, lưu giỏ hàng vào database
            $this->cartModel->addCart($user_id, $cart_session, $product_id, $name, $quantity, $price, $total_price, $color, $size, $image);
        }

        $_SESSION['message'] = "Sản phẩm đã được thêm vào giỏ hàng!";
        header("Location: /carts");
        exit;
    } else {
        renderView("view/cart/create.php", [], "Add to Cart");
    }
}

    public function updateQuantity($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = $_POST['quantity'];
    
            if ($this->cartModel->updateQuantity($id, $quantity)) {
                $_SESSION['message'] = "Cập nhật giỏ hàng thành công";
            } else {
                $_SESSION['error_message'] = $_SESSION['error_message'] ?? "Lỗi khi cập nhật số lượng";
            }
        }
    
        header("Location: /carts");
        exit;
    }
    
    // public function edit($id){
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = $_POST['name'];
    //         $this->categoryModel->updateCategory($id, $name);
    //         header("Location: /categories");
    //     } else {
    //         $categories = $this->categoryModel->getCategoryById($id);
    //         renderView("view/category_edit.php", compact('categories'), "Edit categories");
    //     }
    // }
    public function delete($id) {
        $this->cartModel->deleteCart($id);
        header("Location: /carts");
        exit;
    }
    // Xóa toàn bộ giỏ hàng
    public function clearCart() {
        $user_id = $_SESSION['user']['id'] ?? null;
        $session_id = session_id();
    
        // Xóa giỏ hàng
        $this->cartModel->clearCart($user_id, $session_id);
    
        if (isset($_SESSION['message'])) {
            header("Location: /carts");
        }
        exit;
    }
    
    
    }
