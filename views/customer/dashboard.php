<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/">Home</a></li>
                <li><a href="<?= APP_URL ?>/menu">Menu</a></li>
                <li><a href="<?= APP_URL ?>/orders">My Orders</a></li>
                <li><a href="<?= APP_URL ?>/cart">Cart</a></li>
                <li><a href="<?= APP_URL ?>/profile">Profile</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
        <p>What would you like to order today?</p>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>Browse Menu</h3>
                <p>Check out our latest beverages and snacks.</p>
                <a href="<?= APP_URL ?>/menu" class="btn btn-primary" style="margin-top: 10px;">View Menu</a>
            </div>
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>Order Status</h3>
                <p>Track your active orders.</p>
                <a href="<?= APP_URL ?>/orders" class="btn btn-primary" style="margin-top: 10px;">Track Orders</a>
            </div>
        </div>
    </div>
</body>

</html>