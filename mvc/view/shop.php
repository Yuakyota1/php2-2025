<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #f9f9f9;
        }
        .product-card img {
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .product-card h5 {
            font-size: 1.2rem;
            color: #333;
            font-weight: bold;
        }
        .product-card p {
            font-size: 0.9rem;
            color: #666;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <!-- Thanh tìm kiếm và sắp xếp -->
            <div class="col-md-12 mb-3">
                <form method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category_id'] ?>" <?= ($_GET['category'] ?? '') == $category['category_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select">
                            <option value="">Sắp xếp</option>
                            <option value="asc" <?= ($_GET['sort'] ?? '') == 'asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                            <option value="desc" <?= ($_GET['sort'] ?? '') == 'desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </div>
                </form>
            </div>

            <!-- Danh mục -->
            <div class="col-md-3">
                <h4 class="mb-4">Danh Mục</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="/shop" class="text-decoration-none">Tất cả</a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li class="list-group-item">
                            <a href="?category=<?= $category['category_id'] ?>" class="text-decoration-none">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="col-md-9">
                <h4 class="mb-4">Sản Phẩm</h4>
                <div class="row">
                    <?php
                    
                    // Lọc sản phẩm theo điều kiện tìm kiếm, danh mục, sắp xếp
                    $filteredProducts = $products;

                    // Lọc theo danh mục
                    if (!empty($_GET['category'])) {
                        $filteredProducts = array_filter($filteredProducts, function($product) {
                            return isset($product['category_id']) && $product['category_id'] == $_GET['category'];
                        });
                    }
                    

                    // Tìm kiếm theo tên
                    if (!empty($_GET['search'])) {
                        $searchKeyword = strtolower($_GET['search']);
                        $filteredProducts = array_filter($filteredProducts, function($product) use ($searchKeyword) {
                            return strpos(strtolower($product['name']), $searchKeyword) !== false;
                        });
                    }

                    // Sắp xếp theo giá
                    if (!empty($_GET['sort'])) {
                        usort($filteredProducts, function($a, $b) {
                            if ($_GET['sort'] == 'asc') {
                                return $a['price'] - $b['price'];
                            } else {
                                return $b['price'] - $a['price'];
                            }
                        });
                    }

                    // Hiển thị sản phẩm
                    if (!empty($filteredProducts)): ?>
                        <?php foreach ($filteredProducts as $product) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="product-card">
                                    <!-- Kiểm tra hình ảnh, chỉ lấy ảnh đầu tiên -->
                                    <?php if (!empty($product['images'])): ?>
                                        <img src="/uploads/<?= htmlspecialchars($product['images'][0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
                                    <?php else: ?>
                                        <p class="text-muted">Không có hình ảnh</p>
                                    <?php endif; ?>
                                    <h5><?= htmlspecialchars($product['name']) ?></h5>
                                    <p>
                                        <?= strlen($product['description']) > 100 ? htmlspecialchars(mb_substr($product['description'], 0, 100)) . "..." : htmlspecialchars($product['description']) ?>
                                    </p>
               
                                    <a href="/product_detail/<?= $product['idProduct'] ?>" class="btn btn-primary">Chi tiết</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Không có sản phẩm nào phù hợp.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
