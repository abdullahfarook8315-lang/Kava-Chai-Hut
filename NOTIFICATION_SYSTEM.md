# Notification System Implementation

## Overview
A complete notification system has been implemented for KavaChaiHut to notify customers, managers, and delivery partners about order events.

## Database Changes
Added a new `notifications` table to `database/schema.sql` with the following structure:
- `id`: Primary key
- `user_id`: User receiving the notification
- `order_id`: Related order (nullable)
- `type`: Notification type (order_placed, order_accepted, order_ready, etc.)
- `title`: Notification title
- `message`: Notification message
- `is_read`: Boolean flag for read status
- `created_at`: Timestamp

## Files Created

### 1. **Model: `/models/Notification.php`**
Handles all notification database operations:
- `createNotification()` - Create new notification
- `getUnreadNotifications()` - Get unread notifications for a user
- `getNotifications()` - Get all notifications with pagination
- `markAsRead()` - Mark single notification as read
- `markAllAsRead()` - Mark all notifications as read
- `getUnreadCount()` - Get count of unread notifications
- `deleteNotification()` - Delete a notification
- `getById()` - Get notification by ID

### 2. **Controller: `/controllers/NotificationController.php`**
Handles notification routes:
- `view()` - Display all notifications for user
- `getUnread()` - Get unread notifications (JSON API)
- `markAsRead()` - Mark notification as read
- `markAllAsRead()` - Mark all as read
- `delete()` - Delete notification
- `getCount()` - Get unread count (JSON API)

### 3. **View: `/views/notifications/index.php`**
Main notifications page with:
- List of all notifications
- Notification type badges with color coding
- Mark as read/delete options
- Responsive design

### 4. **Widget: `/views/layouts/notification_bell.php`**
Notification bell widget for navbar:
- Displays notification count badge
- Dropdown with latest unread notifications
- Auto-refresh every 30 seconds
- Click outside to close dropdown

## Modified Files

### 1. **CustomerController.php**
Modified `placeOrder()` to:
- Create notification for customer when order is placed
- Send notifications to all active managers about new order

### 2. **ManagerController.php**
Modified `orderUpdateStatus()` to:
- Notify customer when order status changes to "preparing"
- Notify customer when order status changes to "ready"

### 3. **DeliveryController.php**
Modified:
- `acceptOrder()` - Notify delivery partner and customer when order is assigned
- `updateStatus()` - Notify customer when order is delivered

### 4. **User.php Model**
Added `getUsersByRole()` method to get all active users with specific role

### 5. **public/index.php**
Added routes for notification controller:
- GET `/notifications` - View notifications
- GET `/notifications/unread` - Get unread (JSON)
- POST `/notifications/read` - Mark as read
- POST `/notifications/read-all` - Mark all as read
- POST `/notifications/delete` - Delete notification
- GET `/notifications/count` - Get unread count

### 6. **database/schema.sql**
Added notifications table definition

## Notification Types & Triggers

### Order Placed
- **Customer**: Receives confirmation with order ID and total amount
- **Managers**: Receive new order alert

### Order Accepted (Preparing)
- **Customer**: Notified order is being prepared

### Order Ready
- **Customer**: Notified order is ready for delivery

### Delivery Accepted
- **Delivery Partner**: Receives delivery assignment with address
- **Customer**: Receives delivery partner info

### Order Out for Delivery
- **Customer**: Automatically sent when delivery partner accepts

### Order Delivered
- **Customer**: Receives delivery confirmation

## Features

1. **Real-time Notifications**: Notifications are created immediately on order events
2. **Read/Unread Status**: Users can mark notifications as read
3. **Notification Bell Widget**: Displays unread count in navbar
4. **Auto-refresh**: Notification dropdown refreshes every 30 seconds
5. **Notification Center**: Dedicated page to view all notifications
6. **Type Badges**: Different colors for different notification types
7. **Delete Notifications**: Users can delete individual notifications
8. **Mark All as Read**: Quick action to mark all as read

## Usage

### To Display Notification Bell in Navbar:
Add this line to your navbar view (e.g., in a common header template):
```php
<?php include APP_URL . '/../views/layouts/notification_bell.php'; ?>
```

Or manually include the notification bell widget in any navbar:
```html
<a href="<?= APP_URL ?>/notifications" style="position: relative;">
    🔔
    <span id="notificationBadge" style="position: absolute; top: -5px; right: -5px; 
          background: red; color: white; border-radius: 50%; width: 20px; height: 20px;
          display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
        <!-- Unread count will display here -->
    </span>
</a>
```

### API Endpoints (JSON):
- GET `/notifications/unread` - Returns unread notifications
- GET `/notifications/count` - Returns unread count
- POST `/notifications/read` - Marks notification as read (requires notification_id)
- POST `/notifications/delete` - Deletes notification (requires notification_id)

## Notification Flow Diagram

```
Customer Places Order
    ↓
Create order in database
    ↓
├── Create notification for Customer (order_placed)
├── Create notifications for all Managers (order_placed)
    ↓
Manager Views Order & Changes Status to "Preparing"
    ↓
Create notification for Customer (order_accepted)
    ↓
Manager Changes Status to "Ready"
    ↓
Create notification for Customer (order_ready)
    ↓
Delivery Partner Accepts Order
    ↓
├── Create notification for Delivery Partner (delivery_accepted)
└── Create notification for Customer (order_out_for_delivery)
    ↓
Delivery Partner Updates to "Delivered"
    ↓
Create notification for Customer (order_delivered)
```

## Future Enhancements
1. Email notifications
2. SMS notifications
3. Push notifications
4. Notification preferences per user
5. Notification grouping by order
6. Notification search/filtering
7. Bulk notification management
