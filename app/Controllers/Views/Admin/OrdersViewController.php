<?php

class OrdersViewController extends BaseController{


    private function orders() : OrdersModel{
        return model("OrdersModel");
    }

    public function show() : void{
        view("admin/orders", [
            'table' => $this->getTableOrders()
        ]);
    }

    public function getTableOrders(){
        return [
            'columns' => $this->getColumns(),
            'rows' => $this->orders()->getAll()
        ];
    }


    public function getColumns(){
        $newColumns = [
            'product_name',
            'product_description_large',
            'product_description_short',
            'product_image',
            'product_stock',
            'product_price',
            'user_email',
            'user_name',
            'user_username',
            'user_is_client',
            'order_email',
            'order_phone',
            'name_delivery'
        ];

        /* 
            Las columnas "phone" y "email" ya no seran
            nombradas asi, por que el join las 
            nombra diferente
        */
    
        $columnsFromOrders = $this->orders()->getColumns("orders");
        $filteredColumnsFromOrders = array_filter($columnsFromOrders, function($column) {
            return $column !== 'phone' && $column !== 'email';
        });
    
        return array_merge($filteredColumnsFromOrders, $newColumns);
    }
    
}