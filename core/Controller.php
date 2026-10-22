<?php

class Controller
{

    public function view($view, $data = [])
    {
        extract($data);
        if (file_exists("../views/$view.php")) {
            require_once "../views/$view.php";
        } else {
            die("View does not exist: $view");
        }
    }

    public function model($model)
    {
        require_once "../models/$model.php";
        return new $model();
    }

    public function redirect($url)
    {
        header("Location: " . APP_URL . $url);
        exit;
    }

    protected function requireAuth($allowedRoles = [])
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login/customer');
        }

        if (!empty($allowedRoles)) {
            if (is_array($allowedRoles)) {
                if (!in_array($_SESSION['user_role'], $allowedRoles)) {
                    $this->redirect('/login/customer?error=unauthorized');
                }
            } else {
                if ($_SESSION['user_role'] != $allowedRoles) {
                    $this->redirect('/login/customer?error=unauthorized');
                }
            }
        }
    }
}
