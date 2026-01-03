<?php

class MenuItem extends Model
{

    // Get all menu items
    public function getAll()
    {
        $sql = "SELECT * FROM menu_items ORDER BY category, name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get active menu items (for customers)
    public function getActive()
    {
        $sql = "SELECT * FROM menu_items WHERE availability = 1 ORDER BY category, name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get item by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM menu_items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Add new item
    public function add($data)
    {
        $sql = "INSERT INTO menu_items (name, description, category, price, image_url, availability, created_by) 
                VALUES (:name, :description, :category, :price, :image_url, :availability, :created_by)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':availability', $data['availability']);
        $stmt->bindParam(':created_by', $data['created_by']);

        return $stmt->execute();
    }

    // Update item
    public function update($id, $data)
    {
        $sql = "UPDATE menu_items SET 
                name = :name, 
                description = :description, 
                category = :category, 
                price = :price, 
                image_url = :image_url, 
                availability = :availability 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':availability', $data['availability']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Delete item
    public function delete($id)
    {
        $sql = "DELETE FROM menu_items WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
