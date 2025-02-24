<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "My App" ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar-nav .nav-link:hover {
            color: #f9a825 !important;
        }
        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand h3" href="/home"> 
                    <img src="" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="/shop">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/products">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/categories">Categories</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/images">Images</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/sizes">Sizes</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/product_size_color">Product Size Color</a></li>
                        <li class="nav-item"><a class="nav-link" href="/carts">cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/orders">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="/order">Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="/tracking">Tracking</a></li>
                        <li class="nav-item"><a class="nav-link" href="/user">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/users">Users</a></li>
                        <li class="nav-ttem"><a class="nav-link" href="/admin/report_dashboard">report</a></li>
                    </ul>
                    <div class="d-flex">
                        <?php if (isset($_SESSION['user'])): ?>
                            <span class="navbar-text me-3">Welcome, <?= htmlspecialchars($_SESSION['user']['name']); ?></span>
                            <a href="/logout" class="btn btn-outline-light btn-sm">Logout</a>
                        <?php else: ?>
                            <a href="/login" class="btn btn-outline-light btn-sm me-2">Login</a>
                            <a href="/register" class="btn btn-warning btn-sm">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; <?= date("Y") ?> My App. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
