<!-- Notification Bell Widget -->
<style>
    .notification-bell {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .notification-bell-icon {
        font-size: 1.5rem;
        color: white;
        transition: all 0.3s;
    }

    .notification-bell:hover .notification-bell-icon {
        transform: scale(1.1);
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: bold;
    }

    .notification-dropdown {
        position: absolute;
        top: 50px;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 350px;
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .notification-dropdown.show {
        display: block;
    }

    .notification-dropdown-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        font-weight: bold;
        color: #2c3e50;
    }

    .notification-dropdown-item {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.3s;
    }

    .notification-dropdown-item:hover {
        background: #f9f9f9;
    }

    .notification-dropdown-item.unread {
        background: #f0f8ff;
    }

    .notification-dropdown-item-title {
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 3px;
    }

    .notification-dropdown-item-msg {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }

    .notification-dropdown-item-time {
        font-size: 0.8rem;
        color: #999;
    }

    .notification-dropdown-footer {
        padding: 15px;
        text-align: center;
        border-top: 1px solid #eee;
    }

    .notification-dropdown-footer a {
        color: #3498db;
        text-decoration: none;
        font-weight: bold;
    }

    .notification-dropdown-footer a:hover {
        text-decoration: underline;
    }

    .notification-empty {
        padding: 20px;
        text-align: center;
        color: #999;
    }
</style>

<script>
    function toggleNotificationDropdown() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('show');

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const bell = document.querySelector('.notification-bell');
            if (!bell.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    }

    function loadNotifications() {
        fetch('<?= APP_URL ?>/notifications/unread')
            .then(response => response.json())
            .then(data => {
                const dropdown = document.getElementById('notificationDropdown');
                const itemsContainer = document.getElementById('notificationItems');
                const badge = document.getElementById('notificationBadge');

                if (data.notifications && data.notifications.length > 0) {
                    itemsContainer.innerHTML = '';
                    data.notifications.forEach(notif => {
                        const item = document.createElement('div');
                        item.className = 'notification-dropdown-item unread';
                        item.innerHTML = `
                            <div class="notification-dropdown-item-title">${notif.title}</div>
                            <div class="notification-dropdown-item-msg">${notif.message}</div>
                            <div class="notification-dropdown-item-time">${new Date(notif.created_at).toLocaleString()}</div>
                        `;
                        itemsContainer.appendChild(item);
                    });
                    badge.textContent = data.notifications.length;
                } else {
                    itemsContainer.innerHTML = '<div class="notification-empty">No new notifications</div>';
                    badge.style.display = 'none';
                }
            });
    }

    // Load notifications on page load and every 30 seconds
    window.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        setInterval(loadNotifications, 30000);
    });
</script>

<?php
if (isset($_SESSION['user_id'])) {
    $notificationModel = new Notification();
    $unreadCount = $notificationModel->getUnreadCount($_SESSION['user_id']);
    $unreadNotifications = $notificationModel->getUnreadNotifications($_SESSION['user_id']);
?>
    <div class="notification-bell">
        <div onclick="toggleNotificationDropdown()" style="display: flex; align-items: center;">
            <span class="notification-bell-icon">🔔</span>
            <?php if ($unreadCount > 0): ?>
                <span class="notification-badge" id="notificationBadge"><?= $unreadCount ?></span>
            <?php else: ?>
                <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
            <?php endif; ?>
        </div>

        <div class="notification-dropdown" id="notificationDropdown">
            <div class="notification-dropdown-header">Notifications</div>
            <div id="notificationItems">
                <?php if (!empty($unreadNotifications)): ?>
                    <?php foreach ($unreadNotifications as $notif): ?>
                        <div class="notification-dropdown-item unread">
                            <div class="notification-dropdown-item-title"><?= htmlspecialchars($notif['title']) ?></div>
                            <div class="notification-dropdown-item-msg"><?= htmlspecialchars($notif['message']) ?></div>
                            <div class="notification-dropdown-item-time">
                                <?= date('M d, H:i', strtotime($notif['created_at'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="notification-empty">No new notifications</div>
                <?php endif; ?>
            </div>
            <div class="notification-dropdown-footer">
                <a href="<?= APP_URL ?>/notifications">View All Notifications</a>
            </div>
        </div>
    </div>
<?php } ?>
