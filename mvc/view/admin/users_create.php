<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create User</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Create User</h1>
        <form method="POST" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    required
                    minlength="3"
                    maxlength="50"
                    pattern="[a-zA-Z\s]+"
                    title="Name should only contain letters and spaces. Minimum 3 characters."
                    placeholder="Enter full name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    required
                    title="Please enter a valid email address."
                    placeholder="Enter email address">
                <?php if (isset($error_message) && $error_message): ?>
                    <div class="alert alert-danger mt-2">
                        <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required
                    minlength="8"
                    title="Password must be at least 8 characters long."
                    placeholder="Enter password">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="" disabled selected>Select a role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="" disabled selected>Select a status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Create User</button>
            <?php if (isset($success_message) && $success_message): ?>
                <div class="alert alert-success mt-3">
                    <?= htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
