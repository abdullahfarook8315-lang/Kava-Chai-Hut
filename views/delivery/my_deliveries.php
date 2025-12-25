<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Deliveries - KavaChaiHut</title>
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
        <h1>My Deliveries</h1>

        <?php if (!empty($orders)): ?>
            <div style="display: flex; flex-direction: column; gap: 20px; margin-top: 20px;">
                <?php foreach ($orders as $order): ?>
                    <div
                        style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 5px solid <?= $order['status'] == 'delivered' ? '#27ae60' : '#e67e22' ?>;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h3>Order #<?= $order['id'] ?></h3>
                                <p style="margin: 5px 0;"><strong>Customer:</strong>
                                    <?= htmlspecialchars($order['customer_name']) ?></p>
                                <p style="margin: 5px 0;"><strong>Phone:</strong> <a
                                        href="tel:<?= htmlspecialchars($order['customer_phone']) ?>"><?= htmlspecialchars($order['customer_phone']) ?></a>
                                </p>
                                <p style="margin: 5px 0;"><strong>Address:</strong>
                                    <?= htmlspecialchars($order['delivery_address']) ?></p>
                                <p><strong>Status:</strong> <?= ucfirst(str_replace('_', ' ', $order['status'])) ?></p>
                            </div>

                            <div style="text-align: right;">
                                <?php if ($order['status'] == 'out_for_delivery'): ?>
                                    <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($order['delivery_address']) ?>"
                                        target="_blank" class="btn"
                                        style="background: #3498db; color: white; display: block; margin-bottom: 5px;">Navigate</a>

                                    <form action="<?= APP_URL ?>/delivery/order/update" method="POST">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="btn btn-primary" style="background-color: #27ae60;">Mark
                                            Delivered</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: #27ae60; font-weight: bold;">Completed</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You have no active or past deliveries.</p>
        <?php endif; ?>
    </div>
</body>

</html>