<h2 style="text-align: center; color: #333;">Báo Cáo Thống Kê</h2>

<h3>Tổng quan</h3>
<ul>
    <li>Tổng số sản phẩm: <strong><?= htmlspecialchars($totalProducts) ?></strong></li>
    <li>Tổng số đơn hàng: <strong><?= htmlspecialchars($totalOrders) ?></strong></li>
</ul>

<h3>Doanh thu theo ngày</h3>
<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>Ngày</th>
        <th>Tổng Đơn Hàng</th>
        <th>Doanh Thu (VNĐ)</th>
    </tr>
    <?php foreach ($revenueByDay as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['date']) ?></td>
        <td><?= htmlspecialchars($row['total_orders']) ?></td>
        <td><?= number_format($row['total_revenue'], 0, ',', '.') ?> đ</td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Doanh thu theo tháng</h3>
<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>Năm</th>
        <th>Tháng</th>
        <th>Doanh Thu (VNĐ)</th>
    </tr>
    <?php foreach ($revenueByMonth as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['year']) ?></td>
        <td><?= htmlspecialchars($row['month']) ?></td>
        <td><?= number_format($row['total_revenue'], 0, ',', '.') ?> đ</td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Doanh thu theo năm</h3>
<table border="1" width="100%" cellpadding="10">
    <tr>
        <th>Năm</th>
        <th>Doanh Thu (VNĐ)</th>
    </tr>
    <?php foreach ($revenueByYear as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['year']) ?></td>
        <td><?= number_format($row['total_revenue'], 0, ',', '.') ?> đ</td>
    </tr>
    <?php endforeach; ?>
</table>
<canvas id="revenueChart" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var labels = [];
var today = new Date();
for (var i = 6; i >= 0; i--) {
    var date = new Date();
    date.setDate(today.getDate() - i);
    var formattedDate = date.toISOString().split('T')[0];
    labels.push(formattedDate);
}

var revenueData = labels.map(date => {
    let found = <?= json_encode($revenueByDay) ?>.find(row => row.date === date);
    return found ? found.total_revenue : 0;
});

var ctx = document.getElementById('revenueChart').getContext('2d');
var revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: revenueData,
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 2,
            fill: false
        }]
    }
});

</script>
