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
    
}