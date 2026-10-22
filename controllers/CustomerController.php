<?php

class CustomerController extends Controller
{

    public function __construct()
    {
        // Init
    }

    public function index()
    {
        $this->requireAuth('customer');
        $this->view('customer/dashboard');
    }

    public function menu()
    {
        // Public menu view
        $menuModel = $this->model('MenuItem');
        $items = $menuModel->getActive();
        $this->view('customer/menu', ['items' => $items]);
    }

    public function cart()
    {
        $this->requireAuth('customer');
        $cartModel = $this->model('Cart');
        $cartItems = $cartModel->getCartItems($_SESSION['user_id']);

        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $this->view('customer/cart', ['cartItems' => $cartItems, 'total' => $total]);
    }

    public function addToCart()
    {
        $this->requireAuth('customer');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $menuItemId = $_POST['menu_item_id'];
            $quantity = $_POST['quantity'] ?? 1;

            $cartModel = $this->model('Cart');
            $cartModel->addToCart($_SESSION['user_id'], $menuItemId, $quantity);

            $this->redirect('/cart');
        }
    }

    public function updateCart()
    {
        $this->requireAuth('customer');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cartId = $_POST['cart_id'];
            $quantity = $_POST['quantity'];

            $cartModel = $this->model('Cart');
            $cartModel->updateQuantity($cartId, $quantity, $_SESSION['user_id']);

            $this->redirect('/cart');
        }
    }

    public function removeCartItem()
    {
        $this->requireAuth('customer');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cartId = $_POST['cart_id'];

            $cartModel = $this->model('Cart');
            $cartModel->removeFromCart($cartId, $_SESSION['user_id']);

            $this->redirect('/cart');
        }
    }

    public function orders()
    {
        $this->requireAuth('customer');
        $orderModel = $this->model('Order');
        $orders = $orderModel->getOrdersByCustomer($_SESSION['user_id']);
        $this->view('customer/orders', ['orders' => $orders]);
    }

    public function checkout()
    {
        $this->requireAuth('customer');
        $cartModel = $this->model('Cart');
        $cartItems = $cartModel->getCartItems($_SESSION['user_id']);

        if (empty($cartItems)) {
            $this->redirect('/menu');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Retrieve user address as default
        $userModel = $this->model('User');
        $user = $userModel->getUserById($_SESSION['user_id']);

        $this->view('customer/checkout', ['cartItems' => $cartItems, 'total' => $total, 'address' => $user['address']]);
    }

    public function placeOrder()
    {
        $this->requireAuth('customer');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $deliveryAddress = $_POST['address'];

            $cartModel = $this->model('Cart');
            $cartItems = $cartModel->getCartItems($_SESSION['user_id']);

            if (empty($cartItems)) {
                $this->redirect('/menu');
            }

            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $orderModel = $this->model('Order');
            $orderId = $orderModel->createOrder($_SESSION['user_id'], $total, $deliveryAddress, $cartItems);

            if ($orderId) {
                // Create notification for customer
                $notificationModel = $this->model('Notification');
                $notificationModel->createNotification(
                    $_SESSION['user_id'],
                    $orderId,
                    'order_placed',
                    'Order Placed Successfully',
                    'Your order #' . $orderId . ' has been placed successfully. Total: Rs ' . number_format($total, 2)
                );

                // Create notification for all managers
                $userModel = $this->model('User');
                $managers = $userModel->getUsersByRole('manager');
                foreach ($managers as $manager) {
                    $notificationModel->createNotification(
                        $manager['id'],
                        $orderId,
                        'order_placed',
                        'New Order Received',
                        'New order #' . $orderId . ' received. Total: Rs ' . number_format($total, 2)
                    );
                }

                // Clear Cart
                $cartModel->clearCart($_SESSION['user_id']);
                $this->redirect('/orders?success=order_placed');
            } else {
                die('Order placement failed.');
            }
        }
    }

    public function orderDetails()
    {
        $this->requireAuth('customer');
        $id = $_GET['id'];
        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderDetails($id);

        // Basic security check
        if (!$order || $order['customer_id'] != $_SESSION['user_id']) {
            $this->redirect('/orders');
        }

        $this->view('customer/order-details', ['order' => $order]);
    }

    public function profile()
    {
        $this->requireAuth('customer');
        $this->view('customer/profile');
    }
}
