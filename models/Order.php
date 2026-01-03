<?php

class Order extends Model
{

    public function createOrder($customerId, $totalAmount, $deliveryAddress, $cartItems)
    {
        try {
            $this->db->beginTransaction();

            // 1. Create Order
            $sql = "INSERT INTO orders (customer_id, total_amount, delivery_address, status, payment_status, payment_method) 
                    VALUES (:customer_id, :total_amount, :delivery_address, 'pending', 'pending', 'cash')"; // Defaulting to Cash for now
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':customer_id', $customerId);
            $stmt->bindParam(':total_amount', $totalAmount);
            $stmt->bindParam(':delivery_address', $deliveryAddress);
            $stmt->execute();

            $orderId = $this->db->lastInsertId();

            // 2. Create Order Items
            $sqlItem = "INSERT INTO order_items (order_id, menu_item_id, quantity, price, subtotal) 
                        VALUES (:order_id, :menu_item_id, :quantity, :price, :subtotal)";
            $stmtItem = $this->db->prepare($sqlItem);

            foreach ($cartItems as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $stmtItem->bindParam(':order_id', $orderId);
                $stmtItem->bindParam(':menu_item_id', $item['menu_item_id']);
                $stmtItem->bindParam(':quantity', $item['quantity']);
                $stmtItem->bindParam(':price', $item['price']);
                $stmtItem->bindParam(':subtotal', $subtotal);
                $stmtItem->execute();
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getOrdersByCustomer($customerId)
    {
        $sql = "SELECT * FROM orders WHERE customer_id = :customer_id ORDER BY order_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderDetails($orderId)
    {
        // Get Order
        $sql = "SELECT o.*, u.name as customer_name, u.phone as customer_phone 
                FROM orders o 
                JOIN users u ON o.customer_id = u.id 
                WHERE o.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();
        $order = $stmt->fetch();

        if ($order) {
            // Get Items
            $sqlItems = "SELECT oi.*, m.name as item_name 
                         FROM order_items oi 
                         JOIN menu_items m ON oi.menu_item_id = m.id 
                         WHERE oi.order_id = :order_id";
            $stmtItems = $this->db->prepare($sqlItems);
            $stmtItems->bindParam(':order_id', $orderId);
            $stmtItems->execute();
            $order['items'] = $stmtItems->fetchAll();
        }

        return $order;
    }

    // Manager: Get all orders
    public function getAllOrders($status = null)
    {
        if ($status) {
            $sql = "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.customer_id = u.id WHERE o.status = :status ORDER BY o.order_date ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
        } else {
            $sql = "SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.customer_id = u.id ORDER BY o.order_date DESC";
            $stmt = $this->db->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Delivery: Get available orders (ready for pickup)
    public function getAvailableForDelivery()
    {
        $sql = "SELECT o.*, u.name as customer_name, u.address as customer_address 
                FROM orders o 
                JOIN users u ON o.customer_id = u.id 
                WHERE o.status = 'ready' AND o.delivery_partner_id IS NULL 
                ORDER BY o.order_date ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Update Status
    public function updateStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId);
        return $stmt->execute();
    }

    // Assign Delivery Partner
    public function assignDeliveryPartner($orderId, $partnerId)
    {
        $sql = "UPDATE orders SET delivery_partner_id = :partner_id, status = 'out_for_delivery' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':partner_id', $partnerId);
        $stmt->bindParam(':id', $orderId);
        return $stmt->execute();
    }

    // Delivery Partner: Get My Deliveries
    public function getMyDeliveries($partnerId)
    {
        $sql = "SELECT o.*, u.name as customer_name, u.phone as customer_phone 
                FROM orders o 
                JOIN users u ON o.customer_id = u.id 
                WHERE o.delivery_partner_id = :partner_id 
                ORDER BY o.status DESC, o.order_date DESC"; // Delivered last, active first basically
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':partner_id', $partnerId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
