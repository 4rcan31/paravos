<?php


class ProfileViewController extends BaseController{

    public function user() : UsersModel{
        return model("UsersModel");
    }

    public function order() : OrdersModel{
        return model("OrdersModel");
    }


    public function show(){
        view("profile", [
            "user" => $this->user()->getAllById(
                $this->clientAuth()->id
            ),
            "orders" => [
                "count" => $this->order()->countNumByUserId(
                    $this->clientAuth()->id
                )
            ]
        ]);
    }
}