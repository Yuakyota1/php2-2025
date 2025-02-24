<h1>User Detail</h1>
<p>Name: <?= htmlspecialchars($user['name']) ?></p>
<p>Email: <?= htmlspecialchars($user['email']) ?></p>
<p>Role: <?= htmlspecialchars($user['role']) ?></p>
<p>Status: <?= htmlspecialchars($user['status']) ?></p>
<a href="/users" class="btn btn-secondary">Back to List</a>
