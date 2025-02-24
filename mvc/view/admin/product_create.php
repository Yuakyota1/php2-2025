<h1>Create Product</h1>
<form method="POST" enctype="multipart/form-data"> <!-- Thêm thuộc tính enctype -->
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
    </div>
    
    <label for="images">Hình ảnh:</label>
    <input type="file" name="images[]" multiple>
    
    <div>
        <?php if (!empty($product['images'])): ?>
            <?php foreach ($product['images'] as $image): ?>
                <img src="uploads/<?= htmlspecialchars($image); ?>" alt="Product Image" width="100">
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <button type="submit" class="btn btn-success">Create</button>
</form>
