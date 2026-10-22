<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <div class="navbar-nav">
                <a href="<?= APP_URL ?>/login/customer">Login</a>
                <a href="<?= APP_URL ?>/register">Register</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="auth-container">
            <div class="auth-header">
                <h2>Customer Login</h2>
                <p>Welcome back!</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/login/customer" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <div class="auth-links">
                <a href="#">Forgot Password?</a><br>
                Don't have an account? <a href="<?= APP_URL ?>/register">Register here</a><br><br>
                <small>Log in as:
                    <a href="<?= APP_URL ?>/login/manager">Manager</a> |
                    <a href="<?= APP_URL ?>/login/delivery">Delivery</a> |
                    <a href="<?= APP_URL ?>/login/admin">Admin</a>
                </small>
            </div>
        </div>
    </div>
</body>

</html>