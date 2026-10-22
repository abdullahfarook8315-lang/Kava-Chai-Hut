<?php

class NotificationController extends Controller
{
    public function view()
    {
        $this->requireAuth(); // Require any authenticated user
        $notificationModel = $this->model('Notification');
        $notifications = $notificationModel->getNotifications($_SESSION['user_id']);
        $unreadCount = $notificationModel->getUnreadCount($_SESSION['user_id']);

        $this->view('notifications/index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    public function getUnread()
    {
        $this->requireAuth();
        $notificationModel = $this->model('Notification');
        $unread = $notificationModel->getUnreadNotifications($_SESSION['user_id']);
        
        header('Content-Type: application/json');
        echo json_encode(['notifications' => $unread]);
    }

    public function markAsRead()
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $notificationId = $_POST['notification_id'] ?? null;
            
            if ($notificationId) {
                $notificationModel = $this->model('Notification');
                $notificationModel->markAsRead($notificationId);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            }
        }
    }

    public function markAllAsRead()
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $notificationModel = $this->model('Notification');
            $notificationModel->markAllAsRead($_SESSION['user_id']);
            
            $this->redirect('/notifications');
        }
    }

    public function delete()
    {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $notificationId = $_POST['notification_id'] ?? null;
            
            if ($notificationId) {
                $notificationModel = $this->model('Notification');
                $notificationModel->deleteNotification($notificationId);
                
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            }
        }
    }

    public function getCount()
    {
        $this->requireAuth();
        $notificationModel = $this->model('Notification');
        $unreadCount = $notificationModel->getUnreadCount($_SESSION['user_id']);
        
        header('Content-Type: application/json');
        echo json_encode(['count' => $unreadCount]);
    }
}
