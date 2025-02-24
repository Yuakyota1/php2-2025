<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }
    public function register() {
        $error = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
    
            // Kiểm tra đầu vào
            if (empty($name) || strlen($name) < 3) {
                $error = "Name must be at least 3 characters long.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } elseif (strlen($password) < 8) {
                $error = "Password must be at least 8 characters long.";
            } else {
                // Mã hóa mật khẩu
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                // Gọi phương thức register của UserModel
                try {
                    // Kiểm tra email đã tồn tại chưa
                    if ($this->userModel->emailExists($email)) {
                        $error = "Email is already in use. Please use another one.";
                    } else {
                        if ($this->userModel->register($name, $email, $hashedPassword)) {
                            header("Location: /login");
                            exit;
                        } else {
                            $error = "Registration failed. Please try again later.";
                        }
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage(); // Ghi nhận lỗi nếu xảy ra
                }
            }
        }
    
        renderView("view/auth/register.php", compact('error'), "Register");
    }
    

    public function login() {
        $error = [
            'email' => null,
            'password' => null,
            'general' => null
        ];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']) ?? '';
            $password = trim($_POST['password']) ?? '';
    
            if (empty($email)) {
                $error['email'] = "Vui lòng nhập email.";
            }
    
            if (empty($password)) {
                $error['password'] = "Vui lòng nhập mật khẩu.";
            }
    
            if (!$error['email'] && !$error['password']) {
                try {
                    $user = $this->userModel->login($email, $password);
    
                    if (isset($user['error'])) {
                        $error['general'] = $user['error']; // Lưu lỗi từ UserModel
                    } else {
                        $_SESSION['user'] = $user;
                        header("Location: /home");
                        exit;
                    }
                } catch (Exception $e) {
                    $error['general'] = "Đã có lỗi xảy ra, vui lòng thử lại.";
                }
            }
        }
    
        renderView("view/auth/login.php", compact('error'), "Login");
    }
    
    

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }


    public function forgotPassword() {
        $message = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            // Kiểm tra email tồn tại
            $user = $this->userModel->findUserByEmail($email);
            if ($user) {
                // Tạo OTP và thời gian hết hạn
                $otp = rand(100000, 999999); // OTP ngẫu nhiên gồm 6 chữ số
                $expiration = date('Y-m-d H:i:s', strtotime('+15 minutes')); // OTP hết hạn sau 15 phút

                // Lưu OTP vào database
                if ($this->userModel->storeOtp($email, $otp, $expiration)) {
                    // Gửi email với OTP
                    require 'vendor/autoload.php';

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'adsasiki777@gmail.com';
                        $mail->Password   = 'akhh ibru frvw xfza';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        $mail->setFrom('no-reply@example.com', 'cuong');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Reset Your Password - OTP';
                        $mail->Body    = "Your OTP for password reset is: <strong>$otp</strong><br>
                        link: <a href='http://localhost:8000/reset_password?email=$email&otp=$otp'>Reset Password</a><br>
                                          This OTP will expire in 15 minutes.";
                        $mail->AltBody = "Your OTP for password reset is: $otp. This OTP will expire in 15 minutes.";

                        $mail->send();
                        $message = "An OTP has been sent to your email.";
                    } catch (Exception $e) {
                        $error = "Failed to send OTP email. Error: {$mail->ErrorInfo}";
                    }
                } else {
                    $error = "Failed to generate OTP.";
                }
            } else {
                $error = "Email address not found.";
            }
        }

        renderView("view/auth/forgot_password.php", compact('message', 'error'), "Forgot Password");
    }

    public function resetPassword() {
        $message = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp = $_POST['otp'];
            $newPassword = $_POST['password'];

            // Tìm user dựa trên OTP
            $user = $this->userModel->findUserByOtp($otp);

            if ($user) {
                // Kiểm tra thời gian hết hạn
                if (strtotime($user['otp_expiration']) > time()) {
                    // Cập nhật mật khẩu mới (hashed)
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    if ($this->userModel->updatePassword($user['email'], $hashedPassword)) {
                        $message = "Your password has been reset successfully.";
                    } else {
                        $error = "Failed to reset your password.";
                    }
                } else {
                    $error = "This OTP has expired.";
                }
            } else {
                $error = "Invalid or expired OTP.";
            }
        }

        renderView("view/auth/reset_password.php", compact('message', 'error'), "Reset Password");
    }
    public function updateProfile() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    
        $user = $_SESSION['user'];
        $error = null;
        $message = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
    
            // Kiểm tra dữ liệu đầu vào
            if (empty($name) || strlen($name) < 3) {
                $error = "Name must be at least 3 characters long.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } else {
                try {
                    // Cập nhật thông tin người dùng
                    if ($this->userModel->updateUserProfile($user['id'], $name, $email)) {
                        $_SESSION['user']['name'] = $name;
                        $_SESSION['user']['email'] = $email;
                        $message = "Profile updated successfully.";
                    } else {
                        $error = "Failed to update profile.";
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
    
        renderView("view/user.php", compact('user', 'error', 'message'), "Update Profile");
    }
    
    public function dashboard() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $user = $_SESSION['user'];
        renderView("view/auth/dashboard.php", compact('user'), "Dashboard");
    }
    
}
?>
