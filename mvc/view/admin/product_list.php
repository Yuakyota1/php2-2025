<h1>Danh Sách Sản Phẩm</h1>
<a href="/admin/products/create" class="btn btn-primary mb-3">Tạo Sản Phẩm Mới</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên Sản Phẩm</th>
            <th>Loại Sản Phẩm</th>
            <th>Ảnh</th>
            <th>Mô Tả</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($products) && is_array($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= isset($product['idProduct']) ? $product['idProduct'] : 'Chưa có ID' ?></td>
                    <td><?= isset($product['name']) ? htmlspecialchars($product['name']) : 'Chưa có tên' ?></td>
                    <td><?= isset($product['category_name']) ? htmlspecialchars($product['category_name']) : 'Chưa có loại' ?></td>
                    <td>
                        <?php if (isset($product['images']) && is_array($product['images'])): ?>
                            <?php foreach ($product['images'] as $image): ?>
                                <img src="/uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($image) ?>" style="max-width: 100px; max-height: 100px;">
                            <?php endforeach; ?>
                        <?php elseif (is_string($product['images'])): ?>
                            <?php
                            $imageArray = explode(',', $product['images']);
                            foreach ($imageArray as $image):
                            ?>
                                <img src="/uploads/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($image) ?>" style="max-width: 100px; max-height: 100px;">
                            <?php endforeach; ?>
                        <?php else: ?>
                            Không có ảnh
                        <?php endif; ?>
                    </td>




                    <td><?= isset($product['description']) ? htmlspecialchars($product['description']) : 'Chưa có mô tả' ?></td>
                    <td>
                        <?php if (isset($product['idProduct'])): ?>
                            <a href="/admin/products/edit/<?= $product['idProduct'] ?>" class="btn btn-warning btn-sm">edit</a>
                            <a href="/admin/products/<?= $product['idProduct'] ?>" class="btn btn-success btn-sm">view</a>
                            <a href="/admin/products/delete/<?= $product['idProduct'] ?>" class="btn btn-danger btn-sm">delete</a>
                        <?php else: ?>
                            <span class="text-danger">Hành động không khả dụng</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>