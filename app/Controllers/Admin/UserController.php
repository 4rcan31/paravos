<?php

class UserController extends BaseController{

    public function user() : UsersModel{
        return model("UsersModel");
    }

    public function create($request){
        /* 
            Reutilizar el componente de register de una sola vez
            para no hacerlo de nuevo desde cero xd
        */
        return import("Controllers/Auth/Register.php")->register(
            $request, [
            "redirection" => "/admin/users"
           ]
        );
    }

    public function edit($request){
        $this->validateCsrfTokenWithRedirection($request, "/admin/users");
        /* 
            Aca no voy a usar el validate xd, por que solo los campos que vengan
            con datos voy a actualizar, los demas no, creo que no es la mejor forma
            de hacer esto, pero creo que es la forma mas rapida XD, ahora no es un 
            buen dia para pensar xd
        */

        /* 
            Al final decidi crear esta nueva regla que solo va a verificar de que 
            esos campos vengan aunque no valida que esten vacios o no xd
        */
        $validate = validate($request);
        $validate->rule('keyrequired', ['email', 'name', 'password', 'password_confirm', 'user']);
        $validate->rule("required", ['identifier']);
        $this->validateFieldsWithRedirection(
            "/admin/users",
            $validate
        );
        $columnsFieldsWithData = [];
        if(!empty($validate->input("password"))){
            //significa que quiere cambio de password

            $this->redirectWithBoolCondition(
                $validate->input("password") != $validate->input("password_confirm"),
                "/admin/users",
                ['Las contrasenas no son iguales']
            );
            core('Encrypt/hasher.php', false);
            $columnsFieldsWithData['password'] = Hasher::make($validate->input("password"));
        }

        /* 
            El email, creo que no se deberia de poder modificar xd, por lo tanto, 
            por el momento NO, voy a modificarlo 
        */

        if(!empty($validate->input("name"))){
            $columnsFieldsWithData['name'] = $validate->input("name");
        }

        if(!empty($validate->input(("user")))){
            $columnsFieldsWithData['user'] = $validate->input("user");
        }

        $this->user()->updateFields(
            $validate->input("identifier"),
            $columnsFieldsWithData
        );

        $this->redirectWithBoolCondition(
            true, "/admin/users", ['El usuario se actualizo correctamente!']
        );

    }
}