<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <meta http-equiv="refresh" content="30"> <!-- Refresh every 30s for updates -->
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
        <h2>My Orders</h2>

        <?php if (!empty($orders)): ?>
            <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
                <?php foreach ($orders as $order): ?>
                    <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h3 style="margin-bottom: 5px;">Order #<?= $order['id'] ?></h3>
                                <p style="color: #666; font-size: 0.9rem;"><?= $order['order_date'] ?></p>
                                <p><strong>Total: Rs <?= number_format($order['total_amount'], 2) ?></strong></p>
                            </div>
                            <div style="text-align: right;">
                                <span style="display: inline-block; padding: 5px 10px; border-radius: 15px; font-weight: bold; font-size: 0.9rem;
                                <?php
                                switch ($order['status']) {
                                    case 'pending':
                                        echo 'background: #f1c40f; color: #fff;';
                                        break;
                                    case 'preparing':
                                        echo 'background: #3498db; color: #fff;';
                                        break;
                                    case 'ready':
                                        echo 'background: #9b59b6; color: #fff;';
                                        break;
                                    case 'out_for_delivery':
                                        echo 'background: #e67e22; color: #fff;';
                                        break;
                                    case 'delivered':
                                        echo 'background: #27ae60; color: #fff;';
                                        break;
                                    case 'cancelled':
                                        echo 'background: #c0392b; color: #fff;';
                                        break;
                                }
                                ?>">
                                    <?= ucfirst(str_replace('_', ' ', $order['status'])) ?>
                                </span>
                                <div style="margin-top: 10px;">
                                    <a href="<?= APP_URL ?>/order/view?id=<?= $order['id'] ?>" class="btn"
                                        style="background: #ecf0f1; color: #333; padding: 5px 15px;">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>You haven't placed any orders yet.</p>
            <a href="<?= APP_URL ?>/menu" class="btn btn-primary" style="margin-top: 10px;">Start Ordering</a>
        <?php endif; ?>
    </div>
</body>

</html>