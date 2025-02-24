<h1>Images List</h1>
<a href="/admin/images/upload" class="btn btn-primary mb-3">Upload Images</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Image Name</th> 
            <th>Preview</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($images as $image): ?>
        <tr>
            <td><?= $image['image_id'] ?></td>
            <td><?= $image['name'] ?></td>
            <td>
            <img src="/uploads/<?= $image['name'] ?>" alt="<?= htmlspecialchars($image['name']) ?>" style="max-width: 100px; max-height: 100px;">


            </td>
            <td>
                <a href="/admin/images/<?= $image['image_id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/admin/images/edit/<?= $image['image_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/images/delete/<?= $image['image_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
