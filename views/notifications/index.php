<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - KavaChaiHut</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/style.css">
    <style>
        .notification-container {
            max-width: 800px;
            margin: 20px auto;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .notification-item {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3498db;
            transition: all 0.3s;
        }

        .notification-item.unread {
            background: #f0f8ff;
            border-left-color: #27ae60;
        }

        .notification-item:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .notification-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .notification-message {
            color: #666;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .notification-time {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 10px;
        }

        .notification-type {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-right: 10px;
        }

        .notification-type.order_placed {
            background: #3498db;
            color: white;
        }

        .notification-type.order_accepted {
            background: #9b59b6;
            color: white;
        }

        .notification-type.order_ready {
            background: #f39c12;
            color: white;
        }

        .notification-type.order_out_for_delivery {
            background: #e67e22;
            color: white;
        }

        .notification-type.order_delivered {
            background: #27ae60;
            color: white;
        }

        .notification-type.delivery_accepted {
            background: #2980b9;
            color: white;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .notification-actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-mark-read {
            background: #3498db;
            color: white;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .empty-message {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            color: #666;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= APP_URL ?>/" class="brand">KavaChaiHut</a>
            <ul class="navbar-nav">
                <li><a href="<?= APP_URL ?>/">Home</a></li>
                <li><a href="<?= APP_URL ?>/notifications">Notifications</a></li>
                <li><a href="<?= APP_URL ?>/logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="notification-container">
        <div class="notification-header">
            <h2>Notifications</h2>
            <?php if ($unreadCount > 0): ?>
                <form action="<?= APP_URL ?>/notifications/read-all" method="POST" style="margin: 0;">
                    <button type="submit" class="btn"
                        style="background: #3498db; color: white; padding: 8px 15px; border-radius: 4px;">Mark All as
                        Read</button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-item <?= !$notification['is_read'] ? 'unread' : '' ?>">
                    <div>
                        <span class="notification-type <?= htmlspecialchars($notification['type']) ?>">
                            <?= ucfirst(str_replace('_', ' ', $notification['type'])) ?>
                        </span>
                    </div>
                    <div class="notification-title"><?= htmlspecialchars($notification['title']) ?></div>
                    <div class="notification-message"><?= htmlspecialchars($notification['message']) ?></div>
                    <div class="notification-time">
                        <?= date('M d, Y H:i', strtotime($notification['created_at'])) ?>
                    </div>

                    <?php if (!$notification['is_read']): ?>
                        <div class="notification-actions">
                            <form action="<?= APP_URL ?>/notifications/read" method="POST" style="display: inline;">
                                <input type="hidden" name="notification_id" value="<?= $notification['id'] ?>">
                                <button type="submit" class="btn-mark-read">Mark as Read</button>
                            </form>
                            <form action="<?= APP_URL ?>/notifications/delete" method="POST" style="display: inline;">
                                <input type="hidden" name="notification_id" value="<?= $notification['id'] ?>">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-message">
                <p>No notifications yet.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
