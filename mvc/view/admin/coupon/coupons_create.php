<h1>Create Coupon</h1>
<form method="POST">
    <div class="mb-3">
        <label for="coupon_code" class="form-label">Coupon Code</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code">
    </div>

    <div class="mb-3">
        <label for="discount" class="form-label">Discount (%)</label>
        <input type="number" class="form-control" id="discount" name="discount" min="1" step="0.01">
    </div>

    <div class="mb-3">
        <label for="expiry_date" class="form-label">Expiry Date</label>
        <input type="date" class="form-control" id="expiry_date" name="expiry_date">
    </div>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <button type="submit" class="btn btn-success">Create</button>
</form>
