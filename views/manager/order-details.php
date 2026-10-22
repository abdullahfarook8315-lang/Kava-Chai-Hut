<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order['id'] ?> - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #2c3e50;">
        <div class="container">
            <a href="<?= APP_URL ?>/manager/orders" class="brand">Back to Orders</a>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px; max-width: 800px;">
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <h1>Order #<?= $order['id'] ?></h1>
                    <p>Placed on: <?= $order['order_date'] ?></p>
                </div>
                <div style="text-align: right;">
                    <h3><?= htmlspecialchars($order['customer_name']) ?></h3>
                    <p><?= htmlspecialchars($order['customer_phone']) ?></p>
                </div>
            </div>
            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

            <h3>Order Items</h3>
            <table style="width: 100%; margin-bottom: 20px;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #eee;">
                        <th style="padding: 10px 0;">Item</th>
                        <th style="padding: 10px 0;">Qty</th>
                        <th style="padding: 10px 0;">Price</th>
                        <th style="padding: 10px 0;">Subtotal</th>
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
                <strong>Total: Rs <?= number_format($order['total_amount'], 2) ?></strong>
            </div>

            <div style="background: #f9f9f9; padding: 20px; border-radius: 4px; margin-bottom: 20px;">
                <h4>Delivery Address</h4>
                <p><?= nl2br(htmlspecialchars($order['delivery_address'])) ?></p>
            </div>

            <div style="text-align: center;">
                <form action="<?= APP_URL ?>/manager/order/update" method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                    <h3>Current Status: <span
                            style="color: var(--primary-color)"><?= ucfirst(str_replace('_', ' ', $order['status'])) ?></span>
                    </h3>

                    <div style="margin-top: 15px;">
                        <button type="submit" name="status" value="preparing" class="btn"
                            style="background: #3498db; color: white; <?= $order['status'] != 'pending' ? 'opacity:0.5; pointer-events:none;' : '' ?>">Mark
                            Preparing</button>
                        <button type="submit" name="status" value="ready" class="btn"
                            style="background: #9b59b6; color: white; margin-left:10px; <?= $order['status'] != 'preparing' ? 'opacity:0.5; pointer-events:none;' : '' ?>">Mark
                            Ready</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>