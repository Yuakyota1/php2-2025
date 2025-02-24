<h2 class="mb-4">Checkout</h2>

<!-- Display Cart Items -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Stt</th>
            <th>size</th>
            <th>color</th>
            <th>image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        ?>
        <?php foreach ($carts as $cart): ?>
            <tr>
                <td><?= $cart['id'] ?></td>
                <td><?= $cart['size'] ?></td>
                <td><?= $cart['color'] ?></td>
                <td><img src="/uploads/<?= $cart['image'] ?>" alt="" width="75" height="50"></td>
                <td><?= $cart['quantity'] ?></td>
                <td><?= $cart['price'] ?></td>
                <td><?= $cart['price'] * $cart['quantity'] ?></td>
                <?php $total += $cart['price'] * $cart['quantity']; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h4>Total: <?= $total ?></h4>

<!-- Checkout Form -->
<form action="/checkout" method="POST" class="mt-4">
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" id="address" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea name="note" id="note" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="payment" class="form-label">Payment Method</label>
        <select name="payment" id="payment" class="form-control" required>
            <option value="cod">COD</option>
            <option value="vnpay">VNPAY</option>
            <option value="momo">MOMO</option>
            <option value="zalopay">ZALO PAY</option>
            <option value="paypal">PayPal</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Place Order</button>
    <a href="/carts" class="btn btn-secondary">Back to Cart</a>
</form>
