<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../core/Router.php';
require_once '../core/Controller.php';
require_once '../core/Model.php';

// Autoloading could be added here, but for now we require core files manually 
// and specific controllers/models will be loaded by Router or Controllers.

session_start();

$router = new Router();

// Define Routes
// Auth
$router->get('/login/customer', 'AuthController', 'loginCustomer');
$router->post('/login/customer', 'AuthController', 'loginCustomerPost');
$router->get('/login/manager', 'AuthController', 'loginManager');
$router->post('/login/manager', 'AuthController', 'loginManagerPost');
$router->get('/login/delivery', 'AuthController', 'loginDelivery');
$router->post('/login/delivery', 'AuthController', 'loginDeliveryPost');
$router->get('/login/admin', 'AuthController', 'loginAdmin');
$router->post('/login/admin', 'AuthController', 'loginAdminPost');
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'registerPost');
$router->get('/logout', 'AuthController', 'logout');

// Customer
$router->get('/', 'CustomerController', 'index'); // Home/Dashboard
$router->get('/menu', 'CustomerController', 'menu');
$router->get('/cart', 'CustomerController', 'cart');
$router->post('/cart/add', 'CustomerController', 'addToCart');
$router->post('/cart/update', 'CustomerController', 'updateCart');
$router->post('/cart/remove', 'CustomerController', 'removeCartItem');
$router->get('/checkout', 'CustomerController', 'checkout');
$router->post('/order/place', 'CustomerController', 'placeOrder');
$router->get('/orders', 'CustomerController', 'orders');
$router->get('/order/view', 'CustomerController', 'orderDetails');
$router->get('/profile', 'CustomerController', 'profile');

// Manager
$router->get('/manager/dashboard', 'ManagerController', 'dashboard');
$router->get('/manager/menu', 'ManagerController', 'menu');
$router->get('/manager/menu/create', 'ManagerController', 'menuCreate');
$router->post('/manager/menu/store', 'ManagerController', 'menuStore');
$router->get('/manager/menu/edit', 'ManagerController', 'menuEdit');
$router->post('/manager/menu/update', 'ManagerController', 'menuUpdate');
$router->post('/manager/menu/delete', 'ManagerController', 'menuDelete');
$router->get('/manager/orders', 'ManagerController', 'orders');
$router->post('/manager/order/update', 'ManagerController', 'orderUpdateStatus');
$router->get('/manager/order/view', 'ManagerController', 'orderDetails');

// Delivery
$router->get('/delivery/dashboard', 'DeliveryController', 'dashboard');
$router->get('/delivery/orders', 'DeliveryController', 'availableOrders');
$router->post('/delivery/order/accept', 'DeliveryController', 'acceptOrder');
$router->get('/delivery/my-deliveries', 'DeliveryController', 'myDeliveries');
$router->post('/delivery/order/update', 'DeliveryController', 'updateStatus');

// Admin
$router->get('/admin/dashboard', 'AdminController', 'dashboard');
$router->get('/admin/users', 'AdminController', 'users');
$router->post('/admin/user/delete', 'AdminController', 'userDelete');
$router->post('/admin/user/update', 'AdminController', 'userEdit');

// Notifications
$router->get('/notifications', 'NotificationController', 'view');
$router->get('/notifications/unread', 'NotificationController', 'getUnread');
$router->post('/notifications/read', 'NotificationController', 'markAsRead');
$router->post('/notifications/read-all', 'NotificationController', 'markAllAsRead');
$router->post('/notifications/delete', 'NotificationController', 'delete');
$router->get('/notifications/count', 'NotificationController', 'getCount');

// Run Router
// Get URL from the rewritten query parameter or REQUEST_URI
$url = isset($_GET['url']) ? $_GET['url'] : $_SERVER['REQUEST_URI'];
$base_path = '/kavachaihut/public'; // Adjust if needed
if (strpos($url, $base_path) === 0) {
    $url = substr($url, strlen($base_path));
}
// Remove query string
if (($pos = strpos($url, '?')) !== false) {
    $url = substr($url, 0, $pos);
}
// Ensure URL starts with /
if ($url && $url[0] !== '/') {
    $url = '/' . $url;
}

$router->dispatch($url);
