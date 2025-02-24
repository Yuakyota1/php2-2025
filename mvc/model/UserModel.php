<?php
require_once "Database.php";

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Đăng ký người dùng
    public function register($name, $email, $password) {
        if ($this->isEmailExists($email)) {
            throw new Exception("Email đã tồn tại. Vui lòng sử dụng email khác.");
        }

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    // Kiểm tra email có tồn tại hay không
    public function isEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Trả về true nếu email tồn tại
    }
    
    // Lấy thông tin người dùng bằng email
    public function findUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng nhập người dùng
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$user) {
            return ['error' => "Email không tồn tại."];
        }
    
        if (!password_verify($password, $user['password'])) {
            return ['error' => "Mật khẩu không đúng."];
        }
    
        return $user;
    }
    

    // Lưu OTP vào cơ sở dữ liệu
    public function storeOtp($email, $otp, $expiration) {
        $sql = "UPDATE users SET otp = :otp, otp_expiration = :expiration WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':expiration', $expiration);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    // Tìm người dùng bằng OTP
    public function findUserByOtp($otp) {
        $sql = "SELECT * FROM users WHERE otp = :otp";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':otp', $otp);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật mật khẩu
    public function updatePassword($email, $newPassword) {
        $sql = "UPDATE users SET password = :password, otp = NULL, otp_expiration = NULL WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    // Lấy tất cả người dùng (dành cho dashboard hoặc admin)
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Lấy người dùng theo ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createUser($name, $email, $password, $role, $status) {
        // Kiểm tra email đã tồn tại
        $checkQuery = "SELECT COUNT(*) FROM users WHERE email = :email";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();
        $emailExists = $checkStmt->fetchColumn();
    
        if ($emailExists > 0) {
            // Ném ngoại lệ nếu email đã tồn tại
            throw new Exception("Email already exists.");
        }
    
        // Nếu không trùng lặp, chèn dữ liệu mới
        $query = "INSERT INTO users (name, email, password, role, status) VALUES (:name, :email, :password, :role, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
    public function updateUserProfile($id, $name, $email) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $id]);
    }
    
    // Cập nhật thông tin người dùng
    public function updateUser($id, $name, $email, $password, $role, $status) {
        // Kiểm tra nếu email tồn tại và thuộc về người khác
        $checkQuery = "SELECT COUNT(*) FROM users WHERE email = :email AND id != :id";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->bindParam(':id', $id);
        $checkStmt->execute();
        $emailExists = $checkStmt->fetchColumn();

        if ($emailExists > 0) {
            throw new Exception("Email already exists for another user.");
        }

        $query = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}
?>
