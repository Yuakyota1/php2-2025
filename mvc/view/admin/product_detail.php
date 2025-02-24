<h1><?= htmlspecialchars($product['name']) ?></h1>
<h2><?= htmlspecialchars($product['category_name']) ?></h2>

<?php if (isset($product['images']) && !empty($product['images'])): ?>
    <?php foreach ($product['images'] as $image): ?>
        <img src="/uploads/<?= htmlspecialchars($image['name']) ?>"
            alt="<?= htmlspecialchars($image['name']) ?>"
            style="max-width: 100px; max-height: 100px;">
    <?php endforeach; ?>
<?php else: ?>
    <p>Không có ảnh</p>
<?php endif; ?>

<p><strong>Description:</strong> <?= htmlspecialchars($product['description']) ?></p>

<?php if (isset($product['sizeColors']) && !empty($product['sizeColors'])): ?>
    <?php foreach ($product['sizeColors'] as $sizeColor): ?>
        <p>
            Color: <?= htmlspecialchars($sizeColor['color']) ?>
            <?php if (isset($sizeColor['nameSize'])): ?>
                , Size: <?= htmlspecialchars($sizeColor['nameSize']) ?>
            <?php else: ?>
                , Size: N/A
            <?php endif; ?>

            <!-- Display quantity and price -->
            <?php if (isset($sizeColor['quantity'])): ?>
                , Quantity: <?= htmlspecialchars($sizeColor['quantity']) ?>
            <?php else: ?>
                , Quantity: N/A
            <?php endif; ?>

            <?php if (isset($sizeColor['price'])): ?>
                , Price: <?= number_format($sizeColor['price'], 2) ?> VND
            <?php else: ?>
                , Price: N/A
            <?php endif; ?>
        </p>
    <?php endforeach; ?>
<?php else: ?>
    <p>No size/color information available.</p>
<?php endif; ?>

<a href="/admin/products" class="btn btn-secondary">Back to List</a>
