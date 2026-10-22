<?php

class ManagerController extends Controller
{

    public function dashboard()
    {
        $this->requireAuth('manager');
        $this->view('manager/dashboard');
    }

    // LIST
    public function menu()
    {
        $this->requireAuth('manager');
        $menuModel = $this->model('MenuItem');
        $items = $menuModel->getAll();
        $this->view('manager/menu/index', ['items' => $items]);
    }

    // CREATE FORM
    public function menuCreate()
    {
        $this->requireAuth('manager');
        $this->view('manager/menu/create');
    }

    // STORE
    public function menuStore()
    {
        $this->requireAuth('manager');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Basic Image Upload
            $imageUrl = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Ensure directory exists
                $targetDir = "../public/images/menu/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileExtension, $allowed)) {
                    $fileName = uniqid() . "." . $fileExtension;
                    $targetFile = $targetDir . $fileName;

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        $imageUrl = "images/menu/" . $fileName; // Relative path for DB
                    }
                }
            }

            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'category' => $_POST['category'],
                'price' => $_POST['price'],
                'image_url' => $imageUrl,
                'availability' => isset($_POST['availability']) ? 1 : 0,
                'created_by' => $_SESSION['user_id']
            ];

            $menuModel = $this->model('MenuItem');
            if ($menuModel->add($data)) {
                $this->redirect('/manager/menu');
            } else {
                die('Error adding item.');
            }
        }
    }

    // EDIT FORM
    public function menuEdit()
    {
        $this->requireAuth('manager');
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('/manager/menu');
        }

        $menuModel = $this->model('MenuItem');
        $item = $menuModel->getById($id);

        if (!$item) {
            die('Item not found');
        }

        $this->view('manager/menu/edit', ['item' => $item]);
    }

    // UPDATE
    public function menuUpdate()
    {
        $this->requireAuth('manager');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $menuModel = $this->model('MenuItem');
            $currentItem = $menuModel->getById($id);

            // Handle Image
            $imageUrl = $currentItem['image_url'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $targetDir = "../public/images/menu/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($fileExtension, $allowed)) {
                    $fileName = uniqid() . "." . $fileExtension;
                    $targetFile = $targetDir . $fileName;

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        $imageUrl = "images/menu/" . $fileName;
                    }
                }
            }

            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'category' => $_POST['category'],
                'price' => $_POST['price'],
                'image_url' => $imageUrl,
                'availability' => isset($_POST['availability']) ? 1 : 0
            ];

            if ($menuModel->update($id, $data)) {
                $this->redirect('/manager/menu');
            } else {
                die('Error updating item');
            }
        }
    }

    // DELETE
    public function menuDelete()
    {
        $this->requireAuth('manager');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $menuModel = $this->model('MenuItem');
            $menuModel->delete($id);
            $this->redirect('/manager/menu');
        }
    }

    public function orders()
    {
        $this->requireAuth('manager');
        $orderModel = $this->model('Order');

        $status = $_GET['status'] ?? null;
        $orders = $orderModel->getAllOrders($status);

        $this->view('manager/orders', ['orders' => $orders, 'currentStatus' => $status]);
    }

    public function orderUpdateStatus()
    {
        $this->requireAuth('manager');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];

            $orderModel = $this->model('Order');
            $order = $orderModel->getOrderDetails($orderId);
            $orderModel->updateStatus($orderId, $status);

            // Create notification based on status
            $notificationModel = $this->model('Notification');
            
            if ($status === 'preparing') {
                // Notify customer that order is being prepared
                $notificationModel->createNotification(
                    $order['customer_id'],
                    $orderId,
                    'order_accepted',
                    'Order Accepted',
                    'Your order #' . $orderId . ' has been accepted and is being prepared.'
                );
            } elseif ($status === 'ready') {
                // Notify customer that order is ready
                $notificationModel->createNotification(
                    $order['customer_id'],
                    $orderId,
                    'order_ready',
                    'Order Ready for Delivery',
                    'Your order #' . $orderId . ' is ready and waiting for delivery.'
                );
            }

            $this->redirect('/manager/orders');
        }
    }

    public function orderDetails()
    {
        $this->requireAuth('manager');
        $id = $_GET['id'];
        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderDetails($id);

        $this->view('manager/order-details', ['order' => $order]);
    }
}
