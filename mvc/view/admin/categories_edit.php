<h1>Edit category</h1>
<form method="POST">
    <div class="mb-3">
        <label for="category_name" class="form-label">Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" value="<?= $category['category_name'] ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>