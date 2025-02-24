<h1>Product Size Color List</h1>

<a href="/admin/product_size_color/create" class="btn btn-primary mb-3">Add New</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Product ID</th>
            <th>Color</th>
            <th>Size ID</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Image</th> <!-- Thêm cột hiển thị hình ảnh -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productSizeColors as $item): ?>
        <tr>
            <td><?= $item['idSizeColor'] ?></td>
            <td><?= $item['idProduct'] ?></td>
            <td><?= $item['color'] ?></td>
            <td><?= $item['idSize'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($item['price'], 2) ?> VND</td>
            
            <td>
    <img src="/<?= htmlspecialchars($item['image']) ?>" alt="Product Image" width="100">
</td>


            <td>
                <a href="/admin/product_size_color/<?= $item['idSizeColor'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/admin/product_size_color/edit/<?= $item['idSizeColor'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/product_size_color/delete/<?= $item['idSizeColor'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
