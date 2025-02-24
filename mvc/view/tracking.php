<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra Cứu Đơn Hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .tracking-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .tracking-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #007bff;
        }
        .tracking-container label {
            font-weight: 600;
        }
        .tracking-container .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
        .order-info {
            margin-top: 20px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 5px;
        }
        .order-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="tracking-container">
    <h2>Tra Cứu Đơn Hàng</h2>
    <form action="/tracking" method="GET">
        <div class="mb-3">
            <label for="order_code" class="form-label">Nhập mã đơn hàng:</label>
            <input type="text" class="form-control" name="order_code" id="order_code" required placeholder="Nhập mã đơn hàng...">
        </div>
        <button type="submit" class="btn btn-primary">Tra cứu</button>
    </form>

    <?php if (isset($order)): ?>
        <div class="order-info">
            <h4>Kết quả tra cứu</h4>
            <p><strong>Mã đơn hàng:</strong> <?= htmlspecialchars($order['orderCode']) ?></p>
            <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
            <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['name']) ?></p>
            <p><strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> đ</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
