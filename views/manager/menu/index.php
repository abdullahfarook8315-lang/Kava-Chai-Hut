<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - KavaChaiHut</title>
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
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Menu Management</h1>
            <a href="<?= APP_URL ?>/manager/menu/create" class="btn btn-primary" style="background-color: #27ae60;">Add
                New Item</a>
        </div>

        <table
            style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #ecf0f1; text-align: left;">
                    <th style="padding: 12px;">Image</th>
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Category</th>
                    <th style="padding: 12px;">Price</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px;">
                            <?php if ($item['image_url']): ?>
                                <img src="<?= APP_URL ?>/<?= $item['image_url'] ?>" alt="Img"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <span style="color: #999;">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px;"><?= htmlspecialchars($item['name']) ?></td>
                        <td style="padding: 12px;"><?= ucfirst(htmlspecialchars($item['category'])) ?></td>
                        <td style="padding: 12px;">Rs <?= number_format($item['price'], 2) ?></td>
                        <td style="padding: 12px;">
                            <?php if ($item['availability']): ?>
                                <span style="color: green; font-weight: bold;">Available</span>
                            <?php else: ?>
                                <span style="color: red; font-weight: bold;">Unavailable</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px;">
                            <a href="<?= APP_URL ?>/manager/menu/edit?id=<?= $item['id'] ?>" class="btn"
                                style="background: #3498db; color: white; padding: 5px 10px; font-size: 0.9rem;">Edit</a>

                            <form action="<?= APP_URL ?>/manager/menu/delete" method="POST" style="display: inline;"
                                onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="btn"
                                    style="background: #e74c3c; color: white; padding: 5px 10px; font-size: 0.9rem;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center;">No menu items found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>