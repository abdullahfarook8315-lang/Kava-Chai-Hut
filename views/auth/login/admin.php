<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #34495e;">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut Admin</a>
        </div>
    </nav>

    <div class="container">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Administrator</h2>
                <p>System Management</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/login/admin" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="background-color: #34495e;">Login</button>
            </form>
            <div class="auth-links">
                <small><a href="<?= APP_URL ?>/login/customer">Back to Customer Login</a></small>
            </div>
        </div>
    </div>
</body>

</html>