<h1>Create category</h1>
<form method="POST">
    <div class="mb-3">
        <label for="category_name" class="form-label">Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name">
        <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-success">Create</button>
</form>