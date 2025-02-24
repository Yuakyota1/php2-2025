<h1 class="text-center my-4">Login</h1>

<div class="container">
    <form method="POST" class="w-50 mx-auto border p-4 rounded shadow">
        <!-- Hiển thị lỗi tổng quát -->
        <?php if (!empty($error['general'])): ?>
            <div class="alert alert-danger text-center"><?= $error['general']; ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <?php if (!empty($error['email'])): ?>
                <div class="text-danger"><?= $error['email']; ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            <?php if (!empty($error['password'])): ?>
                <div class="text-danger"><?= $error['password']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3">
        Don't have an account? <a href="/register">Register</a>
    </p>
    <p class="text-center mt-3"><a href="/forgot_password">Forgot password?</a></p>
</div>
