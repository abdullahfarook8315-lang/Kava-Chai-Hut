<?php

class Notification extends Model
{
    protected $table = 'notifications';

    // Create a new notification
    public function createNotification($userId, $orderId, $type, $title, $message)
    {
        $query = "INSERT INTO " . $this->table . " (user_id, order_id, type, title, message, created_at) 
                  VALUES (:user_id, :order_id, :type, :title, :message, NOW())";

        $this->db->prepare($query);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':order_id', $orderId);
        $this->db->bind(':type', $type);
        $this->db->bind(':title', $title);
        $this->db->bind(':message', $message);

        return $this->db->execute();
    }

    // Get unread notifications for a user
    public function getUnreadNotifications($userId)
    {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id AND is_read = FALSE 
                  ORDER BY created_at DESC";

        $this->db->prepare($query);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    // Get all notifications for a user (paginated)
    public function getNotifications($userId, $limit = 20, $offset = 0)
    {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC 
                  LIMIT :limit OFFSET :offset";

        $this->db->prepare($query);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
        $this->db->bind(':offset', (int)$offset, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    // Mark notification as read
    public function markAsRead($notificationId)
    {
        $query = "UPDATE " . $this->table . " 
                  SET is_read = TRUE 
                  WHERE id = :id";

        $this->db->prepare($query);
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }

    // Mark all notifications as read for a user
    public function markAllAsRead($userId)
    {
        $query = "UPDATE " . $this->table . " 
                  SET is_read = TRUE 
                  WHERE user_id = :user_id";

        $this->db->prepare($query);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    // Get count of unread notifications
    public function getUnreadCount($userId)
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                  WHERE user_id = :user_id AND is_read = FALSE";

        $this->db->prepare($query);
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result['count'] ?? 0;
    }

    // Delete a notification
    public function deleteNotification($notificationId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->prepare($query);
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }

    // Get notification by ID
    public function getById($notificationId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $this->db->prepare($query);
        $this->db->bind(':id', $notificationId);
        return $this->db->single();
    }
}
