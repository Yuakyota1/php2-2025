
<h1>Danh Sách Chi Tiết Đơn Hàng</h1>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID Đơn Hàng</th>
            <th>Tên Sản Phẩm</th>
            <th>Kích Cỡ</th>
            <th>Màu Sắc</th>
            <th>Số Lượng</th>
            <th>Giá</th>
            <th>Tổng Tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($order_items) && is_array($order_items)): ?>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= isset($item['order_id']) ? $item['order_id'] : 'Chưa có ID đơn hàng' ?></td>
                    <td><?= isset($item['product_name']) ? htmlspecialchars($item['product_name']) : 'Chưa có tên sản phẩm' ?></td>
                    <td><?= isset($item['size']) ? htmlspecialchars($item['size']) : 'Chưa có kích cỡ' ?></td>
                    <td><?= isset($item['color']) ? htmlspecialchars($item['color']) : 'Chưa có màu sắc' ?></td>
                    <td><?= isset($item['quantity']) ? $item['quantity'] : 'Chưa có số lượng' ?></td>
                    <td><?= isset($item['price']) ? number_format($item['price'], 2) . ' đ' : 'Chưa có giá' ?></td>
                    <td><?= isset($item['price']) && isset($item['quantity']) ? number_format($item['price'] * $item['quantity'], 2) . ' đ' : 'Chưa có tổng tiền' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Không có chi tiết đơn hàng nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>



<a href="/order" class="btn btn-secondary">Back to List</a>