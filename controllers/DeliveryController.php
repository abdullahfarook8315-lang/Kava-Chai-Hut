<?php

class DeliveryController extends Controller
{

    public function dashboard()
    {
        $this->requireAuth('delivery_partner');
        $this->view('delivery/dashboard');
    }

    public function availableOrders()
    {
        $this->requireAuth('delivery_partner');
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAvailableForDelivery();
        $this->view('delivery/available_orders', ['orders' => $orders]);
    }

    public function acceptOrder()
    {
        $this->requireAuth('delivery_partner');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            $orderModel = $this->model('Order');
            $order = $orderModel->getOrderDetails($orderId);
            
            // Assign delivery partner
            $orderModel->assignDeliveryPartner($orderId, $_SESSION['user_id']);

            // Create notification for delivery partner
            $notificationModel = $this->model('Notification');
            $notificationModel->createNotification(
                $_SESSION['user_id'],
                $orderId,
                'delivery_accepted',
                'Delivery Assigned',
                'You have been assigned to deliver order #' . $orderId . '. Address: ' . htmlspecialchars($order['delivery_address'])
            );

            // Create notification for customer
            $userModel = $this->model('User');
            $deliveryPartner = $userModel->getUserById($_SESSION['user_id']);
            $notificationModel->createNotification(
                $order['customer_id'],
                $orderId,
                'order_out_for_delivery',
                'Order Out for Delivery',
                'Your order #' . $orderId . ' is on the way. Delivery Partner: ' . htmlspecialchars($deliveryPartner['name'])
            );

            $this->redirect('/delivery/dashboard');
        }
    }

    public function myDeliveries()
    {
        $this->requireAuth('delivery_partner');
        $orderModel = $this->model('Order');
        $orders = $orderModel->getMyDeliveries($_SESSION['user_id']);
        $this->view('delivery/my_deliveries', ['orders' => $orders]);
    }

    public function updateStatus()
    {
        $this->requireAuth('delivery_partner');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];

            // Validate status transition if needed

            $orderModel = $this->model('Order');
            $order = $orderModel->getOrderDetails($orderId);
            $orderModel->updateStatus($orderId, $status);

            // Create notification for customer when order is delivered
            if ($status === 'delivered') {
                $notificationModel = $this->model('Notification');
                $notificationModel->createNotification(
                    $order['customer_id'],
                    $orderId,
                    'order_delivered',
                    'Order Delivered',
                    'Your order #' . $orderId . ' has been delivered successfully. Thank you for your order!'
                );
            }

            $this->redirect('/delivery/dashboard');
        }
    }
}
