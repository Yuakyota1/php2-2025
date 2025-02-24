<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit User</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit User</h1>
        <form method="POST" class="shadow p-4 rounded bg-light">
            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    name="name" 
                    value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" 
                    required 
                    minlength="3" 
                    maxlength="50" 
                    pattern="[a-zA-Z\s]+"
                    title="Name should only contain letters and spaces. Minimum 3 characters."
                    placeholder="Enter user name">
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" 
                    required 
                    title="Please enter a valid email address."
                    placeholder="Enter email address">
            </div>

            <!-- Role Field -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    value="<?= htmlspecialchars($user['password'], ENT_QUOTES, 'UTF-8') ?>" 
                    required 
                    minlength="8"
                    title="Password must be at least 8 characters long."
                    placeholder="Enter password">
            </div>

            <!-- Status Field -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-warning w-100">Update User</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
