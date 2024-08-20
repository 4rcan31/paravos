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

    public function getProductIdByTrackingNumber(string $trakingNumber){
        $this->prepare();
        $this->select(['product_id'])->from('orders')->where("tracking_number", $trakingNumber);
        return $this->execute()->all()->id ?? null;
    }

    public function getProductIdById(string $id){
        $this->prepare();
        $this->select(['product_id'])->from('orders')->where("id", $id);
        return $this->execute()->all()->product_id ?? null;
    }

    public function existOrderById(string $id) : bool{
        $this->prepare();
        $this->select(['*'])->from("orders")->where("id", $id);
        return $this->execute()->exists();
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

    public function setCancelOrderByIdOrder(string $idOrder){
        $this->prepare();
        $this->update('orders', [
            "payment_status" => "Cancelado",
            "order_status" => 'Cancelado'
        ])->where('id', $idOrder);
        return $this->execute()->lastId();
    }


    public function getTrackingNumberById(string $id){
        $this->prepare();
        $this->select(["tracking_number"])->from("orders")->where("id", $id);
        return $this->execute()->all();
    }

    public function getIdByTrackingNumber(string $trackingNumber){
        $this->prepare();
        $this->select(['id'])->from("orders")->where("tracking_number", $trackingNumber);
        return $this->execute()->all();
    }
    

    public function get(){
        $this->prepare();
        $this->select(["*"])->from("orders");
        return $this->execute()->all("fetchAll");
    }

    public function getAll() {
        $this->prepare();
        return $this->query("
            SELECT 
                orders.id,
                orders.product_id,
                products.name AS product_name,
                products.description_large AS product_description_large,
                products.description_short AS product_description_short,
                products.url_img AS product_image,
                products.stock AS product_stock,
                products.price AS product_price,
                orders.user_id,
                users.email AS user_email,
                users.name AS user_name,
                users.user AS user_username,
                users.is_client AS user_is_client,
                orders.address,
                orders.reference,
                orders.approved_shipping,
                orders.email AS order_email,
                orders.phone AS order_phone,
                orders.payment_status,
                orders.tracking_number,
                orders.shipping_date,
                orders.delivery_time,   
                orders.payment_method,
                orders.order_status,
                orders.created_at,
                orders.delivery_providers_id,
                delivery_providers.name AS name_delivery
            FROM 
                orders
            JOIN 
                products ON orders.product_id = products.id
            JOIN 
                users ON orders.user_id = users.id
            JOIN 
                delivery_providers ON orders.delivery_providers_id = delivery_providers.id
            WHERE 
                orders.approved_shipping = false
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
    
}