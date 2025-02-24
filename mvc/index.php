<?php
require_once "controller/ProductController.php";
require_once "controller/CategoryController.php";
require_once "controller/UserController.php";
require_once "controller/AuthController.php";
require_once "controller/ProductSizeColorController.php";
require_once "controller/SizeController.php";
require_once "controller/ImageController.php";
require_once "middleware.php";
require_once "router/Router.php";
require_once "controller/CartController.php";
require_once "controller/ReportController.php";

session_start();

$router = new Router();
$productController = new ProductController();
$categoryController = new CategoryController();
$userController = new UserController();
$authController = new AuthController();
$prod = new ProductSizeColorController();
$size = new SizeController();
$image = new ImageController();
$cart = new CartController();
$Report = new ReportController();

$router->addRoute("/vnpay_return", [$cart, "vnpayReturn"]);

$router->addRoute("/home", [$productController, "list"]);
$router->addRoute("/shop", [$productController, "shop"]);
$router->addRoute("/product_detail/{id}", [$productController, "detail"]);

$router->addRoute('/user', [$authController, 'updateProfile']);

$router->addRoute('/admin/report_dashboard', [$Report, 'index'],['isAdmin']);

$router->addRoute("/order", [$cart, "userOrders"]);
$router->addRoute("/order_detail/{id}", [$cart, "orderDetail"]);
$router->addRoute("/order/cancel/{id}", [$cart, "cancelOrder"]);
$router->addRoute("/order/delete/{id}", [$cart, "userdelete"]);

$router->addRoute("/tracking", [$cart, "tracking"]);


$router->addRoute("/admin/orders", [$cart, "list"],['isAdmin']);
$router->addRoute("/admin/orders/{id}", [$cart, "show"],['isAdmin']);
$router->addRoute("/admin/orders/edit/{id}", [$cart, "edit"],['isAdmin']);
$router->addRoute("/admin/orders/delete/{id}", [$cart, "deleteOrder"],['isAdmin']);


$router->addRoute('/checkout', [$cart, "checkout"]);

// carts
$router->addRoute("/carts", [$cart, "index"]);
$router->addRoute("/carts/delete/{id}", [$cart, "delete"]);
$router->addRoute('/carts/create', [$cart, "create"]);
$router->addRoute('/carts/update/{id}', [$cart, "updateQuantity"]);
$router->addRoute('/carts/clear', [$cart, "clearCart"]);


$router->addRoute("/admin/images", [$image, "index"],['isAdmin']);
$router->addRoute("/admin/images/upload", [$image, "upload"],['isAdmin']);
$router->addRoute("/admin/images/edit/{id}", [$image, "edit"],['isAdmin']);
$router->addRoute("/admin/images/delete/{id}", [$image, "delete"],['isAdmin']);
$router->addRoute("/admin/images/{id}", [$image, "show"],['isAdmin']);

$router->addRoute("/admin/product_size_color", [$prod, "index"],['isAdmin']);
$router->addRoute("/admin/product_size_color/create", [$prod, "create"],['isAdmin']);
$router->addRoute("/admin/product_size_color/{id}", [$prod, "show"],['isAdmin']);
$router->addRoute("/admin/product_size_color/edit/{id}", [$prod, "edit"],['isAdmin']);
$router->addRoute("/admin/product_size_color/delete/{id}", [$prod, "delete"],['isAdmin']);

$router->addRoute("/admin/sizes", [$size, "index"],['isAdmin']);
$router->addRoute("/admin/sizes/create", [$size, "create"],['isAdmin']);
$router->addRoute("/admin/sizes/{id}", [$size, "show"],['isAdmin']);
$router->addRoute("/admin/sizes/edit/{id}", [$size, "edit"],['isAdmin']);
$router->addRoute("/admin/sizes/delete/{id}", [$size, "delete"],['isAdmin']);

$router->addRoute("/forgot_password", [$authController, "forgotPassword"]);
$router->addRoute("/reset_password", [$authController, "resetPassword"]);
$router->addRoute("/login", [$authController, "login"]);
$router->addRoute("/logout", [$authController, "logout"]);
$router->addRoute("/register", [$authController, "register"]);

$router->addRoute("/admin/users", [$userController, "index"], ['isAdmin']);
$router->addRoute("/admin/users/create", [$userController, "create"], ['isAdmin']);
$router->addRoute("/admin/users/{id}", [$userController, "show"], ['isAdmin']);
$router->addRoute("/admin/users/edit/{id}", [$userController, "edit"], ['isAdmin']);
$router->addRoute("/admin/users/delete/{id}", [$userController, "delete"], ['isAdmin']);

$router->addRoute("/admin/categories", [$categoryController, "index"], ['isAdmin']);
$router->addRoute("/admin/categories/create", [$categoryController, "create"], ['isAdmin']);
$router->addRoute("/admin/categories/{id}", [$categoryController, "show"], ['isAdmin']);
$router->addRoute("/admin/categories/edit/{id}", [$categoryController, "edit"], ['isAdmin']);
$router->addRoute("/admin/categories/delete/{id}", [$categoryController, "delete"], ['isAdmin']);

// Chỉ admin được phép truy cập toàn bộ nhóm products
$router->addRoute("/admin/products", [$productController, "index"], ['isAdmin']);
$router->addRoute("/admin/products/create", [$productController, "create"], ['isAdmin']);
$router->addRoute("/admin/products/edit/{id}", [$productController, "edit"], ['isAdmin']);
$router->addRoute("/admin/products/delete/{id}", [$productController, "delete"], ['isAdmin']);
$router->addRoute("/admin/products/{id}", [$productController, "show"], ['isAdmin']);

$router->dispatch();
?>
