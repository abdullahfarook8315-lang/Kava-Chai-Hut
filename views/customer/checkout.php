<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/">Home</a></li>
                <li><a href="<?= APP_URL ?>/cart">Cart</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px; max-width: 600px;">
        <h2>Checkout</h2>

        <div
            style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
            <h3>Order Summary</h3>
            <ul style="list-style: none; padding: 0; margin: 10px 0;">
                <?php foreach ($cartItems as $item): ?>
                    <li
                        style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding: 5px 0;">
                        <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
                        <span>Rs <?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div
                style="display: flex; justify-content: space-between; font-weight: bold; margin-top: 10px; font-size: 1.1rem;">
                <span>Total Amount:</span>
                <span>Rs <?= number_format($total, 2) ?></span>
            </div>
        </div>

        <form action="<?= APP_URL ?>/order/place" method="POST"
            style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px;">
            <div class="form-group">
                <label for="address">Delivery Address</label>
                <textarea name="address" id="address" class="form-control" rows="3"
                    required><?= htmlspecialchars($address ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Payment Method</label>
                <div style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <input type="radio" name="payment" checked> Cash on Delivery
                    <span style="color: #666; font-size: 0.9rem;">(Online payment coming soon)</span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Place Order</button>
        </form>
    </div>
</body>

</html>