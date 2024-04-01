<?php


class OrdersCardViewController extends BaseController{

    public function orders() : OrdersModel{
        return model("OrdersModel");
    }


    public function show(){
        view("orders", [
            "table" => [
                "columns" => $this->columns(),
                'rows' => $this->rows()
            ]
        ]);
    }


    public function columns(){
        return [
            'Producto',
            'Precio',
            'Direccion',
            'Referencia',
            'Telefono',
            'Estado de pago',
            'Metodo de pago',
            'Estado de orden',
            'Numero de pedido',
            'Fecha aproximada de entrega',
            'Hora aproximada de entrega'
        ];
    }

    public function rows(){
        return $this->orders()->getAllInfoByIdUser(
            $this->clientAuth()->id
        );
    }
}