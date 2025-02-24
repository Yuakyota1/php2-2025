<h1>Edit Product Size Color</h1>

<form action="/admin/product_size_color/edit/<?= $productSizeColor['idSizeColor'] ?>" method="POST">
    <div class="mb-3">
        <label for="idProduct" class="form-label">Product</label>
        <select class="form-control" id="idProduct" name="idProduct">
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['idProduct'] ?>" <?= $productSizeColor['idProduct'] == $product['idProduct'] ? 'selected' : '' ?>>
                    <?= $product['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="color" class="form-label">Color</label>
        <input type="text" class="form-control" id="color" name="color" value="<?= $productSizeColor['color'] ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="idSize" class="form-label">Size</label>
        <select class="form-control" id="idSize" name="idSize">
            <?php foreach ($sizes as $size): ?>
                <option value="<?= $size['idSize'] ?>" <?= $productSizeColor['idSize'] == $size['idSize'] ? 'selected' : '' ?>>
                    <?= $size['nameSize'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Quantity Field -->
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $productSizeColor['quantity'] ?>" required>
    </div>

    <!-- Price Field -->
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $productSizeColor['price'] ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

</form>
