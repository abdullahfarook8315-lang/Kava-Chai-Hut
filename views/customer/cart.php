<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/">Home</a></li>
                <li><a href="<?= APP_URL ?>/menu">Menu</a></li>
                <li><a href="<?= APP_URL ?>/cart">Cart</a></li>
                <li><a href="<?= APP_URL ?>/orders">Orders</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>Your Cart</h1>

        <?php if (!empty($cartItems)): ?>
            <div style="display: flex; flex-direction: column; gap: 20px; margin-top: 20px;">
                <table
                    style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <thead>
                        <tr style="background: #f4f4f4; text-align: left;">
                            <th style="padding: 15px;">Item</th>
                            <th style="padding: 15px;">Price</th>
                            <th style="padding: 15px;">Quantity</th>
                            <th style="padding: 15px;">Subtotal</th>
                            <th style="padding: 15px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                                    <?php if ($item['image_url']): ?>
                                        <img src="<?= APP_URL ?>/<?= $item['image_url'] ?>" width="50" height="50"
                                            style="object-fit: cover; border-radius: 4px;">
                                    <?php endif; ?>
                                    <b><?= htmlspecialchars($item['name']) ?></b>
                                </td>
                                <td style="padding: 15px;">Rs <?= number_format($item['price'], 2) ?></td>
                                <td style="padding: 15px;">
                                    <form action="<?= APP_URL ?>/cart/update" method="POST" style="display: inline;">
                                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="10"
                                            onchange="this.form.submit()" style="width: 50px; padding: 5px;">
                                    </form>
                                </td>
                                <td style="padding: 15px;">Rs <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                <td style="padding: 15px;">
                                    <form action="<?= APP_URL ?>/cart/remove" method="POST">
                                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                        <button type="submit"
                                            style="background: none; border: none; color: red; cursor: pointer; text-decoration: underline;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div
                    style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); align-self: flex-end; width: 300px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 1.1rem;">
                        <strong>Total:</strong>
                        <strong>Rs <?= number_format($total, 2) ?></strong>
                    </div>
                    <form action="<?= APP_URL ?>/checkout" method="GET">
                        <!-- Checkout will be implemented next -->
                        <a href="<?= APP_URL ?>/menu" class="btn"
                            style="background: #ddd; color: #333; display: block; text-align: center; margin-bottom: 10px;">Continue
                            Shopping</a>
                        <button type="button" onclick="alert('Checkout integration coming next!')"
                            class="btn btn-primary">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; margin-top: 50px;">
                <p style="font-size: 1.2rem; margin-bottom: 20px;">Your cart is empty.</p>
                <a href="<?= APP_URL ?>/menu" class="btn btn-primary">Browse Menu</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>