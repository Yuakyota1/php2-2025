
<h1>User List</h1>
<a href="/admin/users/create" class="btn btn-primary mb-3">Create users</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
        <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success">
        User created successfully!
    </div>
<?php endif; ?>

        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['role'] ?></td>
            <td><?= $user['status'] ?></td>
            <td>
                <a href="/admin/users/<?= $user['id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/admin/users/delete/<?= $user['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>