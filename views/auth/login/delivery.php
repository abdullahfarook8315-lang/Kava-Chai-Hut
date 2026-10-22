<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Partner Login - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #27ae60;">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut Delivery</a>
        </div>
    </nav>

    <div class="container">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Delivery Partner</h2>
                <p>Login to start delivering</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/login/delivery" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="background-color: #27ae60;">Login</button>
            </form>
            <div class="auth-links">
                <small><a href="<?= APP_URL ?>/login/customer">Back to Customer Login</a></small>
            </div>
        </div>
    </div>
</body>

</html>