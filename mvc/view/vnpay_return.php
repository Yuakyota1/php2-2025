<?php
session_start();

$vnp_HashSecret = "PFLZG36HZT953580CDM4I6NR6VM5KTD2"; // Chuỗi bí mật

$vnp_SecureHash = $_GET['vnp_SecureHash'];
unset($_GET['vnp_SecureHash']);
ksort($_GET);
$hashData = "";
$i = 0;
foreach ($_GET as $key => $value) {
    if ($i == 1) {
        $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashData .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

// Kiểm tra chữ ký bảo mật
$secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
if ($secureHash === $vnp_SecureHash) {
    if ($_GET['vnp_ResponseCode'] == '00') {
        $_SESSION['message'] = "Thanh toán thành công! Mã đơn hàng: " . $_GET['vnp_TxnRef'];
        // Cập nhật trạng thái đơn hàng trong CSDL
        // $this->orderModel->updateStatus($_GET['vnp_TxnRef'], 'Đã thanh toán');
    } else {
        $_SESSION['error_message'] = "Thanh toán thất bại!";
    }
} else {
    $_SESSION['error_message'] = "Lỗi xác thực thanh toán!";
}

header("Location: /orders");
exit;
