<?php

class Register extends BaseController{

    public function users() : UsersModel{
        return model("UsersModel");
    }

    public function register($request, $dataExtra = []){
        $redirection = $dataExtra['redirection'] ?? "/register";
        $this->validateCsrfTokenWithRedirection($request, $redirection); 
        $validate = validate($request);
        $validate->rule("required", ['email', 'password', "password_confirm", "name"]);

        $this->redirectWithBoolCondition(
            !$validate->validate(),
            $redirection,
            $validate->err()
        );

        $this->redirectWithBoolCondition(
            $validate->input("password") != $validate->input("password_confirm"),
            $redirection,
            ["Las contrasenas no coinciden"]
        );

        $this->redirectWithBoolCondition(
            $this->users()->existByEmail($validate->input("email")),
            $redirection,
            ['Lo sentimos ese email ya esta siendo ocupado!']
        );
        core('Encrypt/hasher.php', false);
        $this->users()->new(
            $validate->input("email"),
            $validate->input("name"),
            $validate->input("name")."_".token(4),
            false, //no es un cliente como tal, es un user cliente por que ya tiene cuenta
            Hasher::make($validate->input("password"))
        );

        $this->redirectWithBoolCondition(true, $redirection == "/register" ? "/login" : $redirection, ["Ahora ya puedes iniciar session!"]);
    }
}