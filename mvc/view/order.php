<h1>Danh Sách Đơn Hàng</h1>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID Đơn Hàng</th>
            <th>code</th>
            <th>Tên Khách Hàng</th>
            <td>email</td>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($orders) && is_array($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= isset($order['id']) ? $order['id'] : 'Chưa có ID' ?></td>
                    <td><?= isset($order['orderCode']) ? $order['orderCode'] : 'Chưa có code' ?></td>
                    <td><?= isset($order['name']) ? htmlspecialchars($order['name']) : 'Chưa có tên' ?></td>
                    <td><?= isset($order['email']) ? htmlspecialchars($order['email']) : 'Chưa có email' ?></td>
                    <td><?= isset($order['phone']) ? htmlspecialchars($order['phone']) : 'Chưa có số điện thoại' ?></td>
                    <td><?= isset($order['address']) ? htmlspecialchars($order['address']) : 'Chưa có địa chỉ' ?></td>
                    <td><?= isset($order['total_price']) ? number_format($order['total_price'], 0, ',', '.') . ' đ' : 'Chưa có tổng tiền' ?></td>
                    <td><?= isset($order['status']) ? htmlspecialchars($order['status']) : 'Chưa có trạng thái' ?></td>
                    <td>
                        <?php if (isset($order['id'])): ?>
                            <a href="/order_detail/<?= $order['id'] ?>" class="btn btn-success btn-sm">Xem</a>

                            <?php if (isset($order['status']) && strtolower(trim($order['status'])) === 'chờ xử lý'): ?>
                                <a href="/order/cancel/<?= $order['id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                    Hủy đơn hàng
                                </a>



                            <?php endif; ?>

                    
                            <?php if (isset($order['status']) && trim($order['status']) === 'Hủy'): ?>
                                <a href="/order/delete/<?= $order['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                            <?php endif; ?>

                        <?php else: ?>
                            <span class="text-danger">Hành động không khả dụng</span>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Không có đơn hàng nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>