<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #2c3e50;">
        <div class="container">
            <a href="<?= APP_URL ?>/manager/dashboard" class="brand">KavaChaiHut Manager</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/manager/dashboard">Dashboard</a></li>
                <li><a href="<?= APP_URL ?>/manager/menu">Menu</a></li>
                <li><a href="<?= APP_URL ?>/manager/orders">Orders</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Incoming Orders</h1>
            <div>
                <a href="<?= APP_URL ?>/manager/orders" class="btn" style="background: #2c3e50; color: white;">All</a>
                <a href="<?= APP_URL ?>/manager/orders?status=pending" class="btn"
                    style="background: #f1c40f; color: black;">Pending</a>
                <a href="<?= APP_URL ?>/manager/orders?status=preparing" class="btn"
                    style="background: #3498db; color: white;">Preparing</a>
                <a href="<?= APP_URL ?>/manager/orders?status=ready" class="btn"
                    style="background: #9b59b6; color: white;">Ready</a>
            </div>
        </div>

        <table
            style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #ecf0f1; text-align: left;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Customer</th>
                    <th style="padding: 12px;">Date</th>
                    <th style="padding: 12px;">Amount</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px;">#<?= $order['id'] ?></td>
                        <td style="padding: 12px;"><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td style="padding: 12px;"><?= $order['order_date'] ?></td>
                        <td style="padding: 12px;">Rs <?= number_format($order['total_amount'], 2) ?></td>
                        <td style="padding: 12px;">
                            <span style="font-weight: bold; padding: 2px 5px; border-radius: 4px;
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
                            }
                            ?>">
                                <?= ucfirst(str_replace('_', ' ', $order['status'])) ?>
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <a href="<?= APP_URL ?>/manager/order/view?id=<?= $order['id'] ?>" class="btn"
                                style="background: #34495e; color: white; padding: 5px 10px; font-size: 0.9rem;">View</a>

                            <?php if ($order['status'] == 'pending'): ?>
                                <form action="<?= APP_URL ?>/manager/order/update" method="POST" style="display: inline;">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <input type="hidden" name="status" value="preparing">
                                    <button type="submit" class="btn"
                                        style="background: #2980b9; color: white; padding: 5px 10px; font-size: 0.9rem;">Start
                                        Preparing</button>
                                </form>
                            <?php elseif ($order['status'] == 'preparing'): ?>
                                <form action="<?= APP_URL ?>/manager/order/update" method="POST" style="display: inline;">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="btn"
                                        style="background: #27ae60; color: white; padding: 5px 10px; font-size: 0.9rem;">Mark
                                        Ready</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center;">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>