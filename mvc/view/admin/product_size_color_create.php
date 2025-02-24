<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="idProduct" class="form-label">Product</label>
        <select class="form-control" id="idProduct" name="idProduct">
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['idProduct'] ?>"><?= $product['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="color" class="form-label">Color</label>
        <input type="text" class="form-control" id="color" name="color" value="<?= isset($productSizeColor) ? $productSizeColor['color'] : '' ?>">
    </div>
    
    <div class="mb-3">
        <label for="idSize" class="form-label">Size</label>
        <select class="form-control" id="idSize" name="idSize">
            <?php foreach ($sizes as $size): ?>
                <option value="<?= $size['idSize'] ?>" <?= isset($productSizeColor) && $productSizeColor['idSize'] == $size['idSize'] ? 'selected' : '' ?>>
                    <?= $size['nameSize'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?= isset($productSizeColor) ? $productSizeColor['quantity'] : '' ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= isset($productSizeColor) ? $productSizeColor['price'] : '' ?>" required>
    </div>

    <!-- Thêm phần upload hình ảnh -->
    <div class="mb-3">
        <label for="image" class="form-label">Product Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>

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
