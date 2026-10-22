<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - KavaChaiHut</title>
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
                <li><a href="<?= APP_URL ?>/profile">Profile</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>Manager Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>Menu Management</h3>
                <p>Add, edit, or remove menu items.</p>
                <a href="<?= APP_URL ?>/manager/menu" class="btn btn-primary" style="background-color: #2c3e50;">Manage
                    Menu</a>
            </div>
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>Incoming Orders</h3>
                <p>View and update order status.</p>
                <a href="<?= APP_URL ?>/manager/orders" class="btn btn-primary" style="background-color: #2c3e50;">View
                    Orders</a>
            </div>
        </div>
    </div>
</body>

</html>