<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
</head>

<body>
    <nav class="navbar" style="background-color: #2c3e50;">
        <div class="container">
            <a href="<?= APP_URL ?>/manager/dashboard" class="brand">KavaChaiHut Manager</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/manager/dashboard">Dashboard</a></li>
                <li><a href="<?= APP_URL ?>/manager/menu">Menu</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px; max-width: 800px;">
        <h2>Add New Menu Item</h2>

        <form action="<?= APP_URL ?>/manager/menu/store" method="POST" enctype="multipart/form-data"
            style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px;">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="tea">Tea</option>
                    <option value="coffee">Coffee</option>
                    <option value="smoothie">Smoothie</option>
                    <option value="shake">Shake</option>
                    <option value="snack">Snack</option>
                    <option value="sandwich">Sandwich</option>
                    <option value="pastry">Pastry</option>
                    <option value="burger">Burger</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Price (Rs)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image (Optional)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="availability" checked> Available for customers
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="background-color: #27ae60;">Add Item</button>
            <a href="<?= APP_URL ?>/manager/menu" class="btn"
                style="background: #95a5a6; color: white; margin-left: 10px;">Cancel</a>
        </form>
    </div>
</body>

</html>