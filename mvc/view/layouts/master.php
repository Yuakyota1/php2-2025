<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "My App" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar-wrapper {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #343a40;
            padding-top: 20px;
        }

        .sidebar-wrapper .nav-link {
            color: #fff;
            padding: 10px 20px;
        }

        .sidebar-wrapper .nav-link:hover {
            background: #495057;
            color: #f9a825;
        }

        .content-wrapper {
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        .content-wrapper {
            margin-left: 260px;
        }
        <?php endif; ?>

        .main-wrapper {
            flex: 1;
        }

        .form-wrapper {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="sidebar-wrapper">
            <h4 class="text-center text-white">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="/admin/products">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/categories">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/orders">Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/users">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/sizes">Sizes</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/product_size_color">Product Size Color</a></li>
                <li class="nav-item"><a class="nav-link" href="/admin/report_dashboard">Reports</a></li>
                <hr class="bg-light">
                <li class="nav-item text-center">
                    <a href="/logout" class="btn btn-outline-light btn-sm">Logout</a>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <header class="header-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand h3" href="/home">My App</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link" href="/shop">Shop</a></li>
                            <li class="nav-item"><a class="nav-link" href="/carts">Cart</a></li>
                            <li class="nav-item"><a class="nav-link" href="/order">Orders</a></li>
                            <li class="nav-item"><a class="nav-link" href="/tracking">Tracking</a></li>
                            <li class="nav-item"><a class="nav-link" href="/user">Profile</a></li>
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
    <?php endif; ?>

    <div class="content-wrapper">
        <main class="main-wrapper container my-5">
            <?= $content ?>
        </main>
        <footer class="footer-wrapper bg-dark text-white py-3">
            <div class="container text-center">
                <p>&copy; <?= date("Y") ?> My App. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
