<style>
    .checkout-form {
    margin-top: 10px;
    margin-left: 570px;
    text-align: center;
}

.checkout-btn {
    background: #ff9900;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.checkout-btn:hover {
    background: #e68a00;
}

    .clear-cart-form {
    margin-top: 15px;
    margin-left: 570px;
    text-align: center;
}

.clear-cart-btn {
    background: red;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.clear-cart-btn:hover {
    background: darkred;
}

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px;
    }

    th {
        background: #f4f4f4;
    }

    img {
        border-radius: 8px;
    }

    input[type="number"] {
        width: 60px;
        text-align: center;
    }

    button {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    button:hover {
        background: #45a049;
    }

    .delete-btn {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }

    .delete-btn:hover {
        text-decoration: underline;
    }

    .cart-container {
        max-width: 800px;
        margin: 20px auto;
        text-align: center;
    }

    .continue-shopping {
        display: inline-block;
        margin-top: 20px;
        background: #007bff;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        text-decoration: none;
    }

    .continue-shopping:hover {
        background: #0056b3;
    }
</style>

<div class="cart-container">
    <h2>🛒 Giỏ Hàng</h2>

    <table>
        <thead>
            <tr>
                <th>Hình Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th>Màu</th>
                <th>Kích Thước</th>
                <th>Số Lượng</th>
                <th>Giá</th>
                <th>Tổng Giá</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($carts)) : ?>
                <?php foreach ($carts as $cart) : ?>
                    <tr>
                        <td>
                        <?php if (!empty($cart['image'])) : ?>
                        <img src="/uploads/<?= htmlspecialchars($cart['image']) ?>" alt="<?= htmlspecialchars($cart['name']) ?>" style="max-width: 100px; max-height: 100px;">
                    <?php else: ?>
                        <p>Không có hình ảnh</p>
                    <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($cart['name']) ?></td>
                        <td><?= htmlspecialchars($cart['color']) ?></td>
                        <td><?= htmlspecialchars($cart['size']) ?></td>
                        <td>
                            <form action="/carts/update/<?= $cart['id'] ?>" method="POST">
                                <input type="number" name="quantity" value="<?= $cart['quantity'] ?>" min="1">
                                <button type="submit">🔄</button>
                            </form>
                        </td>
                        <td><?= number_format($cart['price'], 0, ',', '.') ?> đ</td>
                        <td><?= number_format($cart['total_price'], 0, ',', '.') ?> đ</td>
                        <td>
                            <a href="/carts/delete/<?= $cart['id'] ?>" class="delete-btn" 
                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                ❌ Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">🛒 Giỏ hàng trống</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($carts)) : ?>
        <form action="/carts/clear" method="POST" class="clear-cart-form" 
              onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">
            <button type="submit" class="clear-cart-btn">🗑 Xóa toàn bộ giỏ hàng</button>
        </form>
    <?php endif; ?>
    <form action="/checkout" method="GET" class="checkout-form">
    <?php if (!empty($carts)) : ?>
    <form action="/checkout" method="GET" class="checkout-form">
        <button type="submit" class="checkout-btn">Thanh Toán</button>
    </form>
<?php else: ?>
    <button class="checkout-btn" disabled style="background: #ccc; cursor: not-allowed;">Thanh Toán</button>
<?php endif; ?>

</form>


    <a href="/shop" class="continue-shopping">🔙 Tiếp tục mua sắm</a>
</div>
