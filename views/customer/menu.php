<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .menu-item {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .menu-item:hover {
            transform: translateY(-5px);
        }

        .menu-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .menu-info {
            padding: 15px;
        }

        .menu-price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .btn-add {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-add:hover {
            background-color: #d35400;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/">Home</a></li>
                <li><a href="<?= APP_URL ?>/menu">Menu</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="<?= APP_URL ?>/cart">Cart</a></li>
                    <li><a href="<?= APP_URL ?>/orders">Orders</a></li>
                    <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= APP_URL ?>/login/customer">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 style="margin-top: 20px; text-align: center;">Our Menu</h1>

        <!-- Filter/Categories could go here -->

        <div class="menu-grid">
            <?php foreach ($items as $item): ?>
                <div class="menu-item">
                    <?php if ($item['image_url']): ?>
                        <img src="<?= APP_URL ?>/<?= $item['image_url'] ?>" alt="<?= htmlspecialchars($item['name']) ?>"
                            class="menu-img">
                    <?php else: ?>
                        <div
                            style="height: 200px; background: #eee; display: flex; align-items: center; justify-content: center; color: #888;">
                            No Image</div>
                    <?php endif; ?>

                    <div class="menu-info">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p style="color: #666; font-size: 0.9rem; min-height: 40px;">
                            <?= htmlspecialchars($item['description']) ?></p>
                        <div class="menu-price">Rs <?= number_format($item['price'], 2) ?></div>

                        <form action="<?= APP_URL ?>/cart/add" method="POST">
                            <input type="hidden" name="menu_item_id" value="<?= $item['id'] ?>">
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <input type="number" name="quantity" value="1" min="1" max="10"
                                    style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 4px;">
                                <button type="submit" class="btn-add">Add to Cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($items)): ?>
            <p style="text-align: center; margin-top: 40px; color: #777;">No menu items available at the moment.</p>
        <?php endif; ?>
    </div>
</body>

</html>