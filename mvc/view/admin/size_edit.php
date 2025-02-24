<h1>Edit category</h1>
<form method="POST">
    <div class="mb-3">
        <label for="nameSize" class="form-label">Name</label>
        <input type="text" class="form-control" id="nameSize" name="nameSize" value="<?= $size['nameSize'] ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <?php if (isset($error)): ?>
    <div style="color: red;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

</form>