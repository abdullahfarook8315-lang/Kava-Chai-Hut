<?php

class AuthController extends Controller
{

    public function __construct()
    {
        // Any initialization
    }

    // REGISTER
    public function register()
    {
        $this->view('auth/register');
    }

    public function registerPost()
    {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); // basic sanitization

        $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'address' => trim($_POST['address']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'role' => trim($_POST['role']),
            'error' => ''
        ];

        // Validation
        if (empty($data['email']) || empty($data['password']) || empty($data['name'])) {
            $data['error'] = 'Please fill in all fields.';
        } elseif ($data['password'] != $data['confirm_password']) {
            $data['error'] = 'Passwords do not match.';
        } elseif (strlen($data['password']) < 6) {
            $data['error'] = 'Password must be at least 6 characters.';
        }

        if (empty($data['error'])) {
            $userModel = $this->model('User');

            // Check if email exists
            if ($userModel->findUserByEmail($data['email'])) {
                $data['error'] = 'Email is already taken.';
                $this->view('auth/register', $data);
            } else {
                // Hash Password
                $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);

                // Register User
                if ($userModel->register($data)) {
                    // Redirect based on role or to login
                    $this->redirectBasedOnRoleLogin($data['role']);
                } else {
                    die('Something went wrong.');
                }
            }
        } else {
            $this->view('auth/register', $data);
        }
    }

    // LOGIN HELPERS
    private function redirectBasedOnRoleLogin($role)
    {
        switch ($role) {
            case 'customer':
                $this->redirect('/login/customer');
                break;
            case 'manager':
                $this->redirect('/login/manager');
                break;
            case 'delivery_partner':
                $this->redirect('/login/delivery');
                break;
            case 'admin':
                $this->redirect('/login/admin');
                break;
            default:
                $this->redirect('/login/customer');
        }
    }

    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        switch ($user['role']) {
            case 'customer':
                $this->redirect('/');
                break;
            case 'manager':
                $this->redirect('/manager/dashboard');
                break;
            case 'delivery_partner':
                $this->redirect('/delivery/dashboard');
                break;
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
        }
    }

    // LOGIN METHODS
    // Customer
    public function loginCustomer()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->view('auth/login/customer');
    }

    public function loginCustomerPost()
    {
        $this->handleLogin('customer');
    }

    // Manager
    public function loginManager()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/manager/dashboard');
        }
        $this->view('auth/login/manager');
    }
    public function loginManagerPost()
    {
        $this->handleLogin('manager');
    }

    // Delivery
    public function loginDelivery()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/delivery/dashboard');
        }
        $this->view('auth/login/delivery');
    }
    public function loginDeliveryPost()
    {
        $this->handleLogin('delivery_partner');
    }

    // Admin
    public function loginAdmin()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/admin/dashboard');
        }
        $this->view('auth/login/admin');
    }
    public function loginAdminPost()
    {
        $this->handleLogin('admin');
    }

    // Generic Login Handler
    private function handleLogin($expectedRole)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'error' => ''
        ];

        if (empty($data['email']) || empty($data['password'])) {
            $data['error'] = 'Please enter email and password.';
            $this->view("auth/login/" . ($expectedRole === 'delivery_partner' ? 'delivery' : $expectedRole), $data);
            return;
        }

        $userModel = $this->model('User');
        $loggedInUser = $userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {
            // Check Role
            if ($loggedInUser['role'] === $expectedRole) {
                $this->createUserSession($loggedInUser);
            } else {
                $data['error'] = 'Unauthorized access for this role.';
                $this->view("auth/login/" . ($expectedRole === 'delivery_partner' ? 'delivery' : $expectedRole), $data);
            }
        } else {
            $data['error'] = 'Password or email is incorrect.';
            $this->view("auth/login/" . ($expectedRole === 'delivery_partner' ? 'delivery' : $expectedRole), $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        $this->redirect('/login/customer');
    }
}
