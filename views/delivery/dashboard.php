<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Dashboard - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #27ae60;">
        <div class="container">
            <a href="<?= APP_URL ?>/delivery/dashboard" class="brand">KavaChaiHut Delivery</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/delivery/dashboard">Dashboard</a></li>
                <li><a href="<?= APP_URL ?>/delivery/orders">Available Orders</a></li>
                <li><a href="<?= APP_URL ?>/profile">Profile</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>Delivery Dashboard</h1>
        <p>Ready to deliver, <?= htmlspecialchars($_SESSION['user_name']) ?>?</p>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>New Orders</h3>
                <p>Check for orders ready for pickup.</p>
                <a href="<?= APP_URL ?>/delivery/orders" class="btn btn-primary" style="background-color: #27ae60;">View
                    Available</a>
            </div>
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>My Deliveries</h3>
                <p>Track your current deliveries.</p>
                <a href="<?= APP_URL ?>/delivery/my-deliveries" class="btn btn-primary"
                    style="background-color: #27ae60;">My Deliveries</a>
            </div>
        </div>
    </div>
</body>

</html>