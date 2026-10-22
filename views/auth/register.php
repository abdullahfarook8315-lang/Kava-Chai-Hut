<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KavaChaiHut</title>
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
                <h2>Create Account</h2>
                <p>Join us for delicious food & beverages</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/register" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" required
                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control"
                        rows="2"><?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="role">I am a...</label>
                    <select name="role" id="role" class="form-control">
                        <option value="customer">Customer</option>
                        <option value="manager">Restaurant Manager</option>
                        <option value="delivery_partner">Delivery Partner</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>

            <div class="auth-links">
                Already have an account? <a href="<?= APP_URL ?>/login/customer">Login here</a>
            </div>
        </div>
    </div>
</body>

</html>