<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order['id'] ?> - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/orders">Back to Orders</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px; max-width: 800px;">
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px;">
                <h1>Order #<?= $order['id'] ?></h1>
                <p>Status: <strong><?= ucfirst(str_replace('_', ' ', $order['status'])) ?></strong></p>
                <p>Date: <?= $order['order_date'] ?></p>
            </div>

            <h3>Items</h3>
            <table style="width: 100%; margin-bottom: 20px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #eee;">
                        <th style="padding: 10px 0;">Item</th>
                        <th style="padding: 10px 0;">Qty</th>
                        <th style="padding: 10px 0;">Price</th>
                        <th style="padding: 10px 0;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px 0;"><?= htmlspecialchars($item['item_name']) ?></td>
                            <td style="padding: 10px 0;"><?= $item['quantity'] ?></td>
                            <td style="padding: 10px 0;">Rs <?= number_format($item['price'], 2) ?></td>
                            <td style="padding: 10px 0;">Rs <?= number_format($item['subtotal'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="text-align: right; font-size: 1.2rem; margin-bottom: 20px;">
                <strong>Total Amount: Rs <?= number_format($order['total_amount'], 2) ?></strong>
            </div>

            <div style="background: #f9f9f9; padding: 20px; border-radius: 4px;">
                <h4>Delivery Details</h4>
                <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['delivery_address'])) ?></p>
                <p><strong>Payment:</strong> <?= ucfirst($order['payment_method']) ?>
                    (<?= ucfirst($order['payment_status']) ?>)</p>
            </div>
        </div>
    </div>
</body>

</html>