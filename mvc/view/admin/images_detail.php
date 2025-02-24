<h1><?= $image['name'] ?></h1>
<img src="/uploads/<?= $image['name'] ?>" alt="<?= htmlspecialchars($image['name']) ?>" style="max-width: 100px; max-height: 100px;">
<a href="/admin/images" class="btn btn-secondary">Back to List</a>