<?php

class Cart extends Model
{

    // Add item to cart
    public function addToCart($userId, $menuItemId, $quantity)
    {
        // Check if item already exists in cart for this user
        $sql = "SELECT * FROM cart WHERE customer_id = :customer_id AND menu_item_id = :menu_item_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customer_id', $userId);
        $stmt->bindParam(':menu_item_id', $menuItemId);
        $stmt->execute();
        $existing = $stmt->fetch();

        if ($existing) {
            // Update quantity
            $newQuantity = $existing['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':quantity', $newQuantity);
            $stmt->bindParam(':id', $existing['id']);
            return $stmt->execute();
        } else {
            // Insert new
            $sql = "INSERT INTO cart (customer_id, menu_item_id, quantity) VALUES (:customer_id, :menu_item_id, :quantity)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':customer_id', $userId);
            $stmt->bindParam(':menu_item_id', $menuItemId);
            $stmt->bindParam(':quantity', $quantity);
            return $stmt->execute();
        }
    }

    // Get user's cart
    public function getCartItems($userId)
    {
        $sql = "SELECT c.id as cart_id, c.quantity, m.id as menu_item_id, m.name, m.price, m.image_url 
                FROM cart c 
                JOIN menu_items m ON c.menu_item_id = m.id 
                WHERE c.customer_id = :customer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customer_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Remove item from cart
    public function removeFromCart($cartId, $userId)
    {
        $sql = "DELETE FROM cart WHERE id = :id AND customer_id = :customer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $cartId);
        $stmt->bindParam(':customer_id', $userId);
        return $stmt->execute();
    }

    // Update quantity
    public function updateQuantity($cartId, $quantity, $userId)
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($cartId, $userId);
        }
        $sql = "UPDATE cart SET quantity = :quantity WHERE id = :id AND customer_id = :customer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $cartId);
        $stmt->bindParam(':customer_id', $userId);
        return $stmt->execute();
    }

    // Clear cart
    public function clearCart($userId)
    {
        $sql = "DELETE FROM cart WHERE customer_id = :customer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customer_id', $userId);
        return $stmt->execute();
    }
}
