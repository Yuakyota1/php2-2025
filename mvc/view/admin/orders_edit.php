<h1>Chỉnh Sửa Đơn Hàng</h1>
<form action="/admin/orders/edit/<?= $order['id'] ?>" method="POST">
    <input type="hidden" name="id" value="<?= $order['id'] ?>"> <!-- Sử dụng 'id' thay vì 'order_id' -->

    <div class="form-group">
        <label for="code">Code</label>
        <input type="text" id="code" name="code" class="form-control" value="<?= htmlspecialchars($order['orderCode']) ?>" disabled><label for="code"></label>
    </div>
    <div class="form-group">
        <label for="name">Tên Khách Hàng</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($order['name']) ?>" disabled>
    </div>
    <div class="form-group">
        <label for="phone">Số Điện Thoại</label>
        <input type="text" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($order['phone']) ?>" disabled>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($order['email']) ?>" disabled>
    </div>
    <div class="form-group">
        <label for="address">Địa Chỉ</label>
        <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($order['address']) ?>" disabled>
    </div>
    <div class="form-group">
        <label for="total_price">Tổng Tiền</label>
        <input type="text" id="total_price" name="total_price" class="form-control" value="<?= number_format($order['total_price'], 0, ',', '.') ?>" disabled>
    </div>
    <div class="form-group">
        <label for="status">Trạng Thái</label>
        <select id="status" name="status" class="form-control">
            <option value="chờ xử lý" <?= $order['status'] == 'chờ xử lý' ? 'selected' : '' ?>>chờ xử lý</option>
            <option value="Đang Xử Lý" <?= $order['status'] == 'Đang Xử Lý' ? 'selected' : '' ?>>Đang Xử Lý</option>
            <option value="Chờ Xác Nhận" <?= $order['status'] == 'Chờ Xác Nhận' ? 'seleted': ''?>>Chờ Xác Nhận</option>
            <option value="Đã thanh toán" <?= $order['status'] == 'Đã thanh toán' ? 'selected' : '' ?>>Đã thanh toán</option>
            <option value="Đang Giao Hàng" <?= $order['status'] == 'Đang Giao Hàng' ? 'selected' : '' ?>>Đang Giao Hàng</option>
            <option value="Đã Hoàn Thành" <?= $order['status'] == 'Đã Hoàn Thành' ? 'selected' : '' ?>>Đã Hoàn Thành</option>
            <option value="Hủy" <?= $order['status'] == 'Hủy' ? 'selected' : '' ?>>Hủy</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </div>
</form>