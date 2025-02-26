<h1>Danh Sách Coupon</h1>
<a href="/admin/coupons/create" class="btn btn-primary mb-3">Create Coupon</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID Coupon</th>
            <th>Mã Coupon</th>
            <th>Giảm Giá</th>
            <th>Ngày Tạo</th>
            <th>Ngày Hết Hạn</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>

        <?php if (isset($coupons) && is_array($coupons)): ?>
            <?php foreach ($coupons as $coupon): ?>
                <tr>
                    <td><?= isset($coupon['coupon_id']) ? $coupon['coupon_id'] : 'Chưa có ID' ?></td>
                    <td><?= isset($coupon['coupon_code']) ? htmlspecialchars($coupon['coupon_code']) : 'Chưa có mã' ?></td>
                    <td><?= isset($coupon['discount']) ? number_format($coupon['discount'], 0, ',', '.') . '%' : 'Chưa có giảm giá' ?></td>
                    <td><?= isset($coupon['created_at']) ? htmlspecialchars($coupon['created_at']) : 'Chưa có ngày tạo' ?></td>
                    <td><?= isset($coupon['expired_at']) ? htmlspecialchars($coupon['expired_at']) : 'Chưa có hạn' ?></td>
                    <td>
                        <?php if (isset($coupon['coupon_id'])): ?>
                            <a href="/admin/coupons/edit/<?= $coupon['coupon_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/admin/coupons/<?= $coupon['coupon_id'] ?>" class="btn btn-success btn-sm">Xem</a>
                            <a href="/admin/coupons/delete/<?= $coupon['coupon_id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa coupon này?');">Xóa</a>
                        <?php else: ?>
                            <span class="text-danger">Hành động không khả dụng</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Không có coupon nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
