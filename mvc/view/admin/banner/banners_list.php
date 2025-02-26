<h1>Banners List</h1>
<a href="/admin/banners/create" class="btn btn-primary mb-3">Create Banner</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($banners as $banner): ?>
        <tr>
            <td><?= $banner['banner_id'] ?></td>
            <td><?= htmlspecialchars($banner['title']) ?></td>
            <td>
            <img src="/uploads/banners/<?= htmlspecialchars($banner['image']) ?>" alt="Banner Image" width="100">

            </td>
            <td>
                <a href="/admin/banners/<?= $banner['banner_id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/admin/banners/edit/<?= $banner['banner_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/banners/delete/<?= $banner['banner_id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this banner?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
