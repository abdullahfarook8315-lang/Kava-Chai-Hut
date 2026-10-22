<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Orders - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #27ae60;">
        <div class="container">
            <a href="<?= APP_URL ?>/delivery/dashboard" class="brand">KavaChaiHut Delivery</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/delivery/dashboard">Dashboard</a></li>
                <li><a href="<?= APP_URL ?>/delivery/orders">Available</a></li>
                <li><a href="<?= APP_URL ?>/delivery/my-deliveries">My Deliveries</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>Available Orders</h1>
        <p>Orders ready for pickup</p>

        <?php if (!empty($orders)): ?>
            <div
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                <?php foreach ($orders as $order): ?>
                    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h3>Order #<?= $order['id'] ?></h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 10px;"><?= $order['order_date'] ?></p>

                        <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>

                        <div style="margin-top: 15px;">
                            <form action="<?= APP_URL ?>/delivery/order/accept" method="POST">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #27ae60; width: 100%;">Accept Delivery</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="margin-top: 20px;">No available orders at the moment.</p>
        <?php endif; ?>
    </div>
</body>

</html>