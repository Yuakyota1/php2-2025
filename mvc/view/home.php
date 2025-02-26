<style>
    /* Tổng quan layout sản phẩm */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        padding: 40px 5%;
        justify-items: center;
    }

    /* Card sản phẩm */
    .product-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        text-align: center;
        padding: 15px;
        border: 1px solid #ddd;
    }

    .product-card:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    /* Hình ảnh sản phẩm */
    .product-card img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    /* Tiêu đề sản phẩm */
    .product-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin: 15px 0 5px;
        color: #222;
    }

    /* Danh mục sản phẩm */
    .product-category {
        font-size: 14px;
        color: #007bff;
        margin-bottom: 5px;
        font-weight: bold;
    }

    /* Giá sản phẩm */
    .product-price {
        font-size: 18px;
        font-weight: bold;
        color: #ff4500;
        margin: 5px 0;
    }

    /* Container của form */
    .form-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 15px;
    }

    /* Nút hành động */
    .add-to-cart-btn,
    .btn {
        display: block;
        width: 100%;
        max-width: 200px;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s ease;
        margin: auto;
    }

    /* Nút "Thêm vào giỏ hàng" */
    .add-to-cart-btn {
        background: black;
        color: white;
    }

    .add-to-cart-btn:hover {
        background: #333;
        transform: translateY(-2px);
    }

    /* Nút "Xem chi tiết" */
    .btn {
        background: white;
        color: black;
        border: 1px solid black;
    }

    .btn:hover {
        background: black;
        color: white;
        transform: translateY(-2px);
    }

    /* Tiêu đề */
    .section-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin: 30px 0;
    }

    /* Container danh mục */
    .category-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        padding: 20px;
    }

    /* Hộp danh mục */
    .category-box {
        display: inline-block;
        padding: 15px 25px;
        background: linear-gradient(135deg, #ff7b00, #ff4500);
        color: white;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .category-box:hover {
        background: linear-gradient(135deg, #ff9a3c, #ff6347);
        transform: scale(1.05);
    }

    .product-card h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 10px 0;
        color: #222;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        /* Số dòng tối đa */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .banner-slider {
    width: 100%;
    max-width: 1200px;
    margin: auto;
}

.banner-slider .swiper-slide {
    text-align: center;
}

.banner-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
}


</style>
<!-- Swiper.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        new Swiper(".banner-slider", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });
</script>

<!-- Banner Slider -->
<?php if (!empty($banners)) : ?>
    <div class="swiper banner-slider">
        <div class="swiper-wrapper">
            <?php foreach ($banners as $banner) : ?>
                <div class="swiper-slide">
                    <img src="/uploads/banners/<?= htmlspecialchars($banner['image']) ?>" alt="Banner" class="banner-image">
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Nút điều hướng -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
<?php endif; ?>


<!-- Hiển thị danh mục -->
<h2 class="section-title">Danh Mục Sản Phẩm</h2>
<div class="category-container">
    <?php if (!empty($categories) && is_array($categories)) : ?>
        <?php foreach ($categories as $category) : ?>
            <a href="?category=<?= $category['category_id'] ?>" class="category-box">
                <?= htmlspecialchars($category['category_name']) ?>
            </a>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Không có danh mục nào để hiển thị.</p>
    <?php endif; ?>
</div>

<!-- Hiển thị tiêu đề danh mục -->
<?php if ($categoryId): ?>
    <h3 class="section-title">
        Sản phẩm thuộc danh mục:
        <?= htmlspecialchars($categories[array_search($categoryId, array_column($categories, 'category_id'))]['category_name'] ?? 'Không xác định') ?>
    </h3>
<?php endif; ?>

<!-- Hiển thị sản phẩm -->
<div class="product-grid">
    <?php if (!empty($products)) : ?>
        <?php foreach ($products as $product) : ?>
            <div class="product-card">
                <?php if (!empty($product['images'])): ?>
                    <img src="/uploads/<?= htmlspecialchars($product['images'][0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <p class="text-muted">Không có hình ảnh</p>
                <?php endif; ?>

                <h3>
                    <?= strlen($product['name']) > 30 ? htmlspecialchars(mb_substr($product['name'], 0, 30)) . "..." : htmlspecialchars($product['name']) ?>
                </h3>

                <p class="product-category">
                    <?= !empty($product['category_name']) ? htmlspecialchars($product['category_name']) : "Không có danh mục" ?>
                </p>
                <p class="product-price">
                    <?php
                    if (!empty($product['min_price']) && !empty($product['max_price'])) {
                        echo number_format($product['min_price'] / 1000, 0, ',', '.') . 'k - ' . number_format($product['max_price'] / 1000, 0, ',', '.') . 'k';
                    } elseif (!empty($product['price'])) {
                        echo number_format($product['price'] / 1000, 0, ',', '.') . 'k';
                    } else {
                        echo "Liên hệ";
                    }
                    ?>
                </p>

                <div class="form-container">
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['idProduct'] ?>">
                        <button type="submit" class="add-to-cart-btn">Thêm vào giỏ hàng</button>
                    </form>
                    <a href="product_detail/<?= $product['idProduct'] ?>" class="btn">Xem Chi Tiết</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Không có sản phẩm nào để hiển thị.</p>
    <?php endif; ?>
</div>


<!-- Hiển thị sản phẩm bán chạy -->
<h2 class="section-title">Sản Phẩm Bán Chạy</h2>
<div class="product-grid">
    <?php if (!empty($best_sellers)) : ?>
        <?php foreach ($best_sellers as $product) : ?>
            <div class="product-card">
                <?php if (!empty($product['images'])): ?>
                    <img src="/uploads/<?= htmlspecialchars($product['images'][0]) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <p class="text-muted">Không có hình ảnh</p>
                <?php endif; ?>

                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p class="product-category"><?= htmlspecialchars($product['category_name'] ?? 'Chưa có danh mục') ?></p>
                <p class="product-price">
                    <?php
                    if (!empty($product['min_price']) && !empty($product['max_price'])) {
                        echo number_format($product['min_price'] / 1000, 0, ',', '.') . 'k - ' . number_format($product['max_price'] / 1000, 0, ',', '.') . 'k';
                    } elseif (!empty($product['price'])) {
                        echo number_format($product['price'] / 1000, 0, ',', '.') . 'k';
                    } else {
                        echo "Liên hệ";
                    }
                    ?>
                </p>

                <div class="form-container">
                    <a href="product_detail/<?= $product['idProduct'] ?>" class="btn">Xem Chi Tiết</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Không có sản phẩm bán chạy nào để hiển thị.</p>
    <?php endif; ?>
</div>