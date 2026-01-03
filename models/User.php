<?php

class User extends Model
{

    // Register a new user
    public function register($data)
    {
        $sql = "INSERT INTO users (name, email, phone, address, password_hash, role) VALUES (:name, :email, :phone, :address, :password_hash, :role)";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':password_hash', $data['password_hash']);
        $stmt->bindParam(':role', $data['role']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                return $user;
            }
        }
        return false;
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all users
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Update User Role/Status
    public function updateUser($id, $role, $status)
    {
        $sql = "UPDATE users SET role = :role, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Delete User
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get users by role
    public function getUsersByRole($role)
    {
        $sql = "SELECT * FROM users WHERE role = :role AND status = 'active' ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
