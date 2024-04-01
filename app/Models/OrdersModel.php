<?php

class OrdersModel extends BaseModel{


    public function new(
        int $productId,
        int|null $userId,
        string $address,
        string $phone,
        string $reference = null,
        string $email = null,
        string $paymentStatus = null,
        string $trackingNumber = null,
        string $shippingDate = null,
        string $deliveryTime = null,
        string $orderStatus = null) {
        $this->prepare();
        $this->insert("orders")->values([
            'product_id' => $productId,
            'user_id' => $userId,
            'address' => $address,
            'reference' => $reference,
            'email' => $email,
            'phone' => $phone,
            'payment_status' => $paymentStatus,
            'order_status' => $orderStatus,
            'tracking_number' => $trackingNumber,
            'shipping_date' => $shippingDate,
            'delivery_time' => $deliveryTime,
        ]);
        return $this->execute()->lastId();
    }

    public function countNumByUserId(string $id){
        $this->prepare();
        $this->select()->count()->from("orders")->where("user_id", $id);
        return $this->execute()->fetchColumn();
    }
    

    public function getByUserId(string $id){
        $this->prepare();
        $this->select(['*'])->from('orders')->where('user_id', $id);
        return $this->execute()->all('fetchAll');
    }

    public function getAllInfoByIdUser(string $id){
        return $this->query('SELECT
                        products.name,
                        products.price,
                        orders.address,
                        orders.reference,
                        orders.phone,
                        orders.payment_status,
                        orders.payment_method,
                        orders.order_status,
                        orders.tracking_number,
                        orders.shipping_date,
                        orders.delivery_time
                    FROM
                        orders
                    INNER JOIN
                        products ON orders.product_id = products.id
                    WHERE
                        orders.user_id = ?;
                ', [$id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setCancelOrderByTrakingNumber(string $trackingNumber){
        $this->prepare();
        $this->update('orders', [
            "payment_status" => "Cancelado",
            "order_status" => 'Cancelado'
        ])->where('tracking_number', $trackingNumber);
        return $this->execute()->lastId();
    }
}