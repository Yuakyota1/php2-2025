<h1>Chỉnh sửa Coupon</h1>

<form method="POST">
    <div class="mb-3">
        <label for="coupon_code" class="form-label">Mã Coupon</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" value="<?= htmlspecialchars($coupon['coupon_code']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="discount" class="form-label">Giảm giá (%)</label>
        <input type="number" class="form-control" id="discount" name="discount" value="<?= htmlspecialchars($coupon['discount']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="expired_at" class="form-label">Ngày hết hạn</label>
        <input type="datetime-local" class="form-control" id="expired_at" name="expired_at" 
            value="<?= isset($coupon['expired_at']) ? date('Y-m-d\TH:i', strtotime($coupon['expired_at'])) : '' ?>">
    </div>

    <button type="submit" class="btn btn-warning">Cập nhật</button>
</form>
