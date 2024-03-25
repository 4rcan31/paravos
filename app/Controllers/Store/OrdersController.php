<?php
Form();

class OrdersController extends BaseController{

    public function orders() : OrdersModel{
        return model("OrdersModel");
    }

    public function makeOrder($request){
        $this->validateCsrfTokenWithRedirection($request, "/products");
        $validate = validate($request);
        $validate->rule("required", ['name', 'phoneNumber', 'addressDelivery', 'deliveryDate', 'deliveryTime', 'amount', 'idProduct']);
        $validate->rule("date", ['deliveryDate']);
        $validate->rule("time", ['deliveryTime']);
        $validate->rule("phone", ['phoneNumber']);
        if(!$validate->validate()){ Form::send('/show/'.$validate->input('idProduct'), $validate->err(), 'Error'); }

        if(Sauth::exitsClientAutheticated()){
            $this->orders()->new(
                $validate->input("idProduct"),
                $this->clientAuth()->id,
                false, //por que no es un "cliente" como tal, es un usuario-cliente
                $validate->input("addressDelivery"),
                $validate->input("phoneNumber"),
                $validate->input("reference") ? $validate->input("reference") : "",
                $validate->input("email") ? $validate->input("email") : "",
                "Pendiente", //pendiente por que se acaba de hacer la orden
                $this->trakingNumberOrder(),
                $validate->input("deliveryDate"),
                $validate->input("deliveryTime"),
                "Pendiente" //por que se acaba de hacer xd
            );
            Form::send('/show/'.$validate->input('idProduct'), ["Se registro correctamente tu orden"], "Notice");
            //significa que es un cliente con session
        }else{

        }


    }


    public function trakingNumberOrder(){
        return token(8); //8 para que el usuario mas o menos pueda dictarlo
    }
    
}