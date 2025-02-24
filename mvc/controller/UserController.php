<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";

class userController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        renderView("view/admin/users_list.php", compact('users'), "User List");
    }

    public function show($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            die("User not found.");
        }
        renderView("view/admin/users_detail.php", compact('user'), "User Detail");
    }

    public function create() {
        $error_message = null;
        $success_message = null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = $_POST['role'];
            $status = $_POST['status'];
    
            try {
               
                $this->userModel->createUser($name, $email, $password, $role, $status);
    
           
                $success_message = "User created successfully!";
            } catch (Exception $e) {
              
                $error_message = $e->getMessage();
            }
        }
    
        renderView("view/admin/users_create.php", compact('error_message', 'success_message'), "Create User");
        
    }
    
    

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = $_POST['role'];
            $status = $_POST['status'];

            $this->userModel->updateUser($id, $name, $email, $password, $role, $status);
            header("Location: /admin/users");
        } else {
            $user = $this->userModel->getUserById($id);
            if (!$user) {
                die("User not found.");
            }
            renderView("view/admin/users_edit.php", compact('user'), "Edit User");
        }
    }

    public function delete($id) {
        $this->userModel->deleteUser($id);
        header("Location: /admin/users");
    }
    // public function login() {
    //     $error_message = null;
    
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $email = $_POST['email'];
    //         $password = $_POST['password'];
    
    //         $user = $this->userModel->getUserByEmail($email);
    
    //         if ($user && password_verify($password, $user['password'])) {
     
    //             session_start();
    //             $_SESSION['user_id'] = $user['id'];
    //             $_SESSION['user_role'] = $user['role'];
    
    //             header("Location: /categories");
    //             exit;
    //         } else {
    //             $error_message = "Invalid email or password.";
    //         }
    //     }
    

    //     renderView("view/login.php", compact('error_message'), "Login");
    // }
    // public function register() {
    //     $error_message = null;
    //     $success_message = null;
    
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $name = $_POST['name'];
    //         $email = $_POST['email'];
    //         $password = $_POST['password'];
    //         $confirm_password = $_POST['confirm_password'];
    
          
    //         if ($password !== $confirm_password) {
    //             $error_message = "Passwords do not match.";
    //         } else {
         
    //             $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
               
    //             $role = 'user'; 
    //             $status = 'active'; 
    
    //             try {
               
    //                 $this->userModel->createUser($name, $email, $hashed_password, $role, $status);
    
                  
    //                 $success_message = "Registration successful. Please log in.";
    
    //             } catch (Exception $e) {
              
    //                 $error_message = $e->getMessage();
    //             }
    //         }
    //     }
    

    //     renderView("view/register.php", compact('error_message', 'success_message'), "Register");
    // }
    

}
