<div style="max-width: 1000px; margin: 20px auto; padding: 20px; font-family: Arial, sans-serif; display: flex; gap: 30px;">
    <div style="flex: 2;">
        <?php if (isset($product['images']) && !empty($product['images'])): ?>
            <div class="slider" style="position: relative; overflow: hidden;">
                <div class="slides" style="display: flex; transition: transform 0.5s ease;">
                <?php if (isset($product['images']) && is_array($product['images'])): ?>
                            <?php foreach ($product['images'] as $image): ?>
                                <img src="/uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($image) ?>" style="max-width: 100%; height: auto; display: block;">

                            <?php endforeach; ?>
                        <?php elseif (is_string($product['images'])): ?>
                            <?php
                            $imageArray = explode(',', $product['images']);
                            foreach ($imageArray as $image):
                            ?>
                                <img src="/uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($image) ?>" style="max-width: 100px; max-height: 100px;">
                            <?php endforeach; ?>
                        <?php else: ?>
                            Không có ảnh
                        <?php endif; ?>
                </div>
                <button class="prev" style="position: absolute; top: 50%; left: 10px; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 15px; cursor: pointer; font-size: 18px;">&#10094;</button>
                <button class="next" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; padding: 15px; cursor: pointer; font-size: 18px;">&#10095;</button>
            </div>
   <?php else: ?>
    <p>Không có hình ảnh cho sản phẩm.</p>
<?php endif; ?>
    </div>
    
    <!-- Phần hiển thị thông tin sản phẩm -->
    <div style="flex: 3;">
        <h1 style="font-size: 32px; color: #333; margin-bottom: 15px;">
            <?= htmlspecialchars($product['name']) ?>
        </h1>
        <h2 style="font-size: 24px; color: #555; margin-bottom: 25px;">
            Category: <?= htmlspecialchars($product['category_name']) ?>
        </h2>
        <p style="font-size: 18px; color: #444; line-height: 1.8; text-align: justify;">
            <strong>Mô tả:</strong> <?= htmlspecialchars($product['description']) ?>
        </p>

        <!-- Thông tin giá và số lượng -->
        <div id="product-info" style="margin-top: 20px;">
            <p id="product-price" style="font-size: 22px; color: #e74c3c; font-weight: bold;">Giá: --</p>
            <p id="product-quantity" style="font-size: 18px; color: #555;">Số lượng: --</p>
        </div>

        <!-- Tùy chọn màu và kích thước -->
        <?php if (isset($product['sizeColors']) && !empty($product['sizeColors'])): ?>
            <div style="margin-top: 25px;">
                <h3 style="font-size: 24px; color: #333;">Tùy Chọn Sản Phẩm:</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="font-size: 18px; color: #555;">Chọn Màu:</label>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <?php $uniqueColors = array_unique(array_column($product['sizeColors'], 'color')); ?>
                            <?php foreach ($uniqueColors as $color): ?>
                                <button type="button" class="color-btn" data-color="<?= htmlspecialchars($color) ?>" style="padding: 12px 25px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; cursor: pointer; font-size: 16px;">
                                    <?= htmlspecialchars($color) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 18px; color: #555;">Chọn Size:</label>
                        <div id="size-container" style="display: flex; gap: 15px; flex-wrap: wrap;"></div>
                    </div>
                    <br>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #888; margin-top: 25px;">Không có thông tin size/color.</p>
        <?php endif; ?>

        <!-- Form thêm sản phẩm vào giỏ hàng -->
        <form method="POST" action="/carts/create">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['idProduct']) ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
            <input type="hidden" name="selected_color" id="selected_color" value="">
            <input type="hidden" name="selected_size" id="selected_size" value="">
            <input type="hidden" name="price" id="price" value="">
            <input type="hidden" name="image" value="<?= htmlspecialchars($product['images'][0] ?? '') ?>">


            <div>
                <label>Số lượng:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
            </div>
            <br>
            <button type="submit" class="add-to-cart-btn-product" style="padding: 12px 25px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Thêm vào giỏ hàng</button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="/shop" style="display: inline-block; padding: 12px 25px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 18px; transition: background-color 0.3s;">Quay lại danh sách</a>
        </div>
    </div>
</div>
<h2 style="font-size: 24px; color: #333;">Sản phẩm liên quan</h2>
<?php if (!empty($relatedProducts)): ?>
    <div style="margin-top: 50px;">
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <?php foreach ($relatedProducts as $related): ?>
                <div style="border: 1px solid #ddd; padding: 15px; width: 200px; text-align: center; border-radius: 5px;">
                    <a href="/product_detail/<?= htmlspecialchars($related['idProduct']) ?>">
                        <img src="/uploads/<?= htmlspecialchars(explode(',', $related['images'])[0]) ?>" 
                             alt="<?= htmlspecialchars($related['name']) ?>" 
                             style="max-width: 100%; height: auto; border-radius: 5px;">
                        <h3 style="font-size: 18px; color: #555;"><?= htmlspecialchars($related['name']) ?></h3>
                    </a>
                    <a href="/product_detail/<?= htmlspecialchars($related['idProduct']) ?>" 
                       style="display: block; margin-top: 10px; padding: 8px 15px; background-color: #007bff; color: white; 
                              text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;">
                        Xem chi tiết
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelector('.slides');
    const images = document.querySelectorAll('.slides img');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    let currentIndex = 0;
    const totalImages = images.length;

    function updateSlider() {
        slides.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    prevButton.addEventListener('click', function() {
        currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
        updateSlider();
    });

    nextButton.addEventListener('click', function() {
        currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
        updateSlider();
    });
});

const sizeColors = <?= json_encode($product['sizeColors']) ?>;
const colorButtons = document.querySelectorAll('.color-btn');
const sizeContainer = document.getElementById('size-container');
const priceDisplay = document.getElementById('product-price');
const quantityDisplay = document.getElementById('product-quantity');
const addToCartButton = document.getElementById('add-to-cart');
const quantityInput = document.getElementById('quantity');

let selectedColor = '';
let selectedSize = '';

colorButtons.forEach(button => {
    button.addEventListener('click', function() {
        colorButtons.forEach(btn => btn.style.borderColor = '#ccc');
        this.style.borderColor = '#007bff';
        selectedColor = this.getAttribute('data-color');
        sizeContainer.innerHTML = '';

        const filteredSizes = sizeColors.filter(item => item.color === selectedColor)
                                        .map(item => item.nameSize);
        const uniqueSizes = [...new Set(filteredSizes)];

        uniqueSizes.forEach(size => {
            const sizeButton = document.createElement('button');
            sizeButton.type = 'button';
            sizeButton.textContent = size || 'N/A';
            sizeButton.style.padding = '12px 25px';
            sizeButton.style.border = '1px solid #ccc';
            sizeButton.style.borderRadius = '5px';
            sizeButton.style.backgroundColor = '#f9f9f9';
            sizeButton.style.cursor = 'pointer';
            sizeButton.style.fontSize = '16px';

            sizeButton.addEventListener('click', () => {
                document.querySelectorAll('#size-container button').forEach(btn => btn.style.borderColor = '#ccc');
                sizeButton.style.borderColor = '#007bff';
                selectedSize = size;
                updateProductInfo();
            });

            sizeContainer.appendChild(sizeButton);
        });

        priceDisplay.textContent = 'Giá: --';
        quantityDisplay.textContent = 'Số lượng: --';
    });
});

function updateProductInfo() {
    const selectedProduct = sizeColors.find(item => item.color === selectedColor && item.nameSize === selectedSize);

    if (selectedProduct) {
        priceDisplay.textContent = `Giá: ${Number(selectedProduct.price).toLocaleString('vi-VN')} đ`;
        quantityDisplay.textContent = `Số lượng: ${selectedProduct.quantity}`;

        // Cập nhật giá trị cho các input ẩn
        document.getElementById('selected_color').value = selectedColor;
        document.getElementById('selected_size').value = selectedSize;
        document.getElementById('price').value = selectedProduct.price;
        document.getElementById('available_quantity').value = selectedProduct.quantity;
    } else {
        priceDisplay.textContent = 'Giá: --';
        quantityDisplay.textContent = 'Số lượng: --';
    }
}
</script>
