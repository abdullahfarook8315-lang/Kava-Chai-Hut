<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #34495e;">
        <div class="container">
            <a href="<?= APP_URL ?>/admin/dashboard" class="brand">KavaChaiHut Admin</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/admin/dashboard">Dashboard</a></li>
                <li><a href="<?= APP_URL ?>/admin/users">Users</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <h1>Admin Dashboard</h1>
        <p>System Overview</p>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>User Management</h3>
                <p>Manage customers, managers, and drivers.</p>
                <a href="<?= APP_URL ?>/admin/users" class="btn btn-primary" style="background-color: #34495e;">Manage
                    Users</a>
            </div>
            <div class="card"
                style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3>System Reports</h3>
                <p>View sales and activity reports.</p>
                <a href="#" class="btn btn-primary" style="background-color: #34495e;">View Reports</a>
            </div>
        </div>
    </div>
</body>

</html>