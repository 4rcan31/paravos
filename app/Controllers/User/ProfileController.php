<?php

//TODO: agregar el validador de csrf token, desde la clase profile no se estan enviando xd
class ProfileController extends BaseController{

    public function user() : UsersModel{
        return model("UsersModel");
    }

    public function updateName($request){
        //$this->validateCsrfTokenWithRedirection($request, "/profile");
        $validate = validate($request);
        $validate->rule("required", ['name']);
        $this->redirectWithBoolCondition(
            !$validate->validate(),
            "/profile",
            $validate->err()
        );

        $this->user()->updateName(
            $this->clientAuth()->id,
            $validate->input('name')
        );

        $this->redirectWithBoolCondition(
            true,
            "/profile",
            ['Se actualizo correctamente su nombre a '.$validate->input('name')]
        );
    }


    public function updateUser($request){
        //$this->validateCsrfTokenWithRedirection($request, "/profile");
        $validate = validate($request);
        $validate->rule('required', ['user']);
        $this->redirectWithBoolCondition(
            !$validate->validate(),
            "/profile",
            $validate->err()
        );

        $this->user()->updateUser(
            $this->clientAuth()->id,
            $validate->input("user")
        );

        $this->redirectWithBoolCondition(true,
        "/profile",
        ['Su usuario se actualizo correctamente a '.$validate->input("user")]);
    }
}