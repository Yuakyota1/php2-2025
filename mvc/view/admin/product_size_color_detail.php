<h1>Product Size Color Detail</h1>

<p><strong>ID:</strong> <?= $productSizeColor['idSizeColor'] ?></p>
<p><strong>Color:</strong> <?= $productSizeColor['color'] ?></p>
<p><stong>quantity:</stong><?= $productSizeColor['quantity']?></p>
<p><stong>price:</stong><?= $productSizeColor['price']?></p>


<a href="/admin/product_size_color/edit/<?= $productSizeColor['idSizeColor'] ?>" class="btn btn-warning">Edit</a>
<a href="/admin/product_size_color" class="btn btn-secondary">Back to List</a>
