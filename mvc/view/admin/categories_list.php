<h1>categories List</h1>
<a href="/admin/categories/create" class="btn btn-primary mb-3">Create categories</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $category['category_id'] ?></td>
            <td><?= $category['category_name'] ?></td>
            <td>
                <a href="/admin/categories/<?= $category['category_id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/admin/categories/edit/<?= $category['category_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/categories/delete/<?= $category['category_id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>