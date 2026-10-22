<?php

class AdminController extends Controller
{

    public function dashboard()
    {
        $this->requireAuth('admin');
        $this->view('admin/dashboard');
    }

    public function users()
    {
        $this->requireAuth('admin');
        $userModel = $this->model('User');
        $users = $userModel->getAllUsers();
        $this->view('admin/users', ['users' => $users]);
    }

    public function userDelete()
    {
        $this->requireAuth('admin');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['user_id'];
            if ($id == $_SESSION['user_id']) {
                $this->redirect('/admin/users?error=cannot_delete_self');
            } else {
                $userModel = $this->model('User');
                $userModel->deleteUser($id);
                $this->redirect('/admin/users');
            }
        }
    }

    public function userEdit()
    {
        $this->requireAuth('admin');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['user_id'];
            $role = $_POST['role'];
            $status = $_POST['status'];

            $userModel = $this->model('User');
            $userModel->updateUser($id, $role, $status);
            $this->redirect('/admin/users');
        }
    }
}
