

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center text-primary">🔍 Kết Quả Tra Cứu</h3>
        <?php if (isset($order)): ?>
            <div class="mt-3">
                <p><strong>Mã đơn hàng:</strong> <span class="text-success"><?= htmlspecialchars($order['orderCode']) ?></span></p>
                <p><strong>Trạng thái:</strong> 
                    <span class="badge bg-info"><?= htmlspecialchars($order['status']) ?></span>
                </p>
                <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['name']) ?></p>
                <p><strong>Tổng tiền:</strong> 
                    <span class="text-danger fw-bold"><?= number_format($order['total_price'], 0, ',', '.') ?> đ</span>
                </p>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                ❌ Không tìm thấy đơn hàng!
            </div>
        <?php endif; ?>
    </div>
</div>
