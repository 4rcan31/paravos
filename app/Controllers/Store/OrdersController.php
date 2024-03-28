<?php
Form();

class OrdersController extends BaseController{

    public function orders() : OrdersModel{
        return model("OrdersModel");
    }

    public function user() : UsersModel{
        return model("UsersModel");
    }

    public function phone() : PhonesModel{
        return model("PhonesModel");
    }

    public function products() : ProductsModel{
        return model("ProductsModel");
    }

    //Todo: Esta funcion la verdad se puede ultra optimizar xD
    public function makeOrder($request){
        $this->validateCsrfTokenWithRedirection($request, "/products");
        $validate = validate($request);
        $validate->rule("required", ['name', 'phoneNumber', 'addressDelivery', 'deliveryDate', 'deliveryTime', 'amount', 'idProduct']);
        $validate->rule("date", ['deliveryDate']);
        $validate->rule("time", ['deliveryTime']);
        $validate->rule("phone", ['phoneNumber']);
        $this->validateFieldsWithRedirection(
            '/show/'.$validate->input('idProduct'),
            $validate
        );
        $IdProduct = $validate->input("idProduct");
        $stock = $this->products()->stockById($IdProduct);
        if($stock === -1){
            Form::send("/products", ['Este producto parece no existir'], "Error");
        }

        if($stock == 0){
            //esto hay que arreglarlo por que quiero hacer la posibilidad de hacer ordenes sin haber productos
            // que funcione como una orden temporal para el futuro
            Form::send("/products", ['Lo lamentamos, pero no se puede hacer ordenes por que no hay producto'], "Error");
        }

        if(Sauth::exitsClientAutheticated()){
            $this->orders()->new(
                $validate->input("idProduct"),
                $this->clientAuth()->id,
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

            $email = $validate->input("email") !== "" ?  $validate->input("email") : "unknow.paravos@".token(4).".com";

                /* 
                    Si pasa esto quiere decir que un cliente quiso hacer una orden sin iniciar session
                    pero ese correo ya esta usado por alguien mas asi que tiene que iniciar session
                    TODO: La verdad esto no me encanta del todo, ya que le da informacion a un atacandte
                    de que ese correo esta registrado
                */
                $this->redirectWithBoolCondition(
                    $this->user()->existsByEmailInUserWithAcount($email),
                    "/register",
                    ['El correo que pusiste ya tiene una cuenta, asi que puedes iniciar session!'],
                    "Notice"
                );


            $phone = $validate->input("phoneNumber");
            $idUser = -1;

            //esto al final de cuentas solamente tiene buscar en los usuarios que no tienen cuenta
            if($this->phone()->existsByNumberInUserWithAoutAcount($phone)){
                $idUser = $this->phone()->getUserIdByNumber($phone);
            }else{
                import('Encrypt/hasher.php', false, '/core');
                $idUser = $this->user()->new(
                    $email,
                    $validate->input("name"),
                    $validate->input("name")."_user",
                    true, //por que es un cliente sin cuenta
                    Hasher::make(token()) //una contrasena aleatoria que basicamente nadie la sabra xD
                );
                $this->phone()->new(
                    $idUser,
                    $phone,
                    true //es el primero, asi que es el principal
                );
            }

            if($idUser != -1){
                $this->orders()->new(
                    $validate->input("idProduct"),
                    $idUser,
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
                    //significa que si o si se hizo una orden asi que hay que restarle al socket
                $this->products()->updateStock(
                        $IdProduct, 
                        $stock - 1 //se le resta uno por que es una nueva orden
                );
                Form::send('/show/'.$validate->input('idProduct'), ["Se registro correctamente tu orden"], "Notice");
            }else{
                Form::send("/", ['Hubo un error bastante grave, no se reconocio un id de cliente!'], "Error");
            }

  
        }
    

    }


    public function trakingNumberOrder(){
        return token(8); //8 para que el usuario mas o menos pueda dictarlo
    }
    
}