<?php

class PartnersController extends BaseController{


    public function partner() : PartnersModel{
        return model("PartnersModel");
    }

    public function create($request){
        $validate = validate($request);
        $validate->rule('required', [
            'name',
            'description',
            'latitude',
            'longitude',
            'img'
        ]);
        $this->validateFieldsWithRedirection("/admin/partners", $validate);
        $this->redirectWithBoolCondition(
            File::isEmptyFile($validate->input("img")),
            "/admin/partners",
            ['Tienes que subir una imagen']
        );
        $this->redirectWithBoolCondition(
            !File::setFile($validate->input("img")),
            "/admin/partners",
            ['Tu archivo es invalido']
        );

        $this->redirectWithBoolCondition(
            !File::upload(),
            "/admin/partners",
            ['Ocurrio un error al subir la imagen']
        );

        $this->partner()->new(
            $validate->input("name"),
            $validate->input("description"),
            File::lastFileUploadInfo('rute:upload'),
            $validate->input("latitude"),
            $validate->input("longitude")
        );

        $this->redirectWithBoolCondition(
            true,
            "/admin/partners",
            ["El partner se agrego con exito!"]
        );
    }

    public function edit($request){
        $validate = validate($request);
        $validate->rule("required", [
            'name',
            'description',
            'latitude',
            'longitude'
        ]);
        $validate->rule("numeric", [
            'latitude',
            'longitude'
        ]);
        $this->validateFieldsWithRedirection("/admin/partners", $validate);
        $id = $validate->input("identifier");
        $this->redirectWithBoolCondition(
            !$this->partner()->existById(
                $id
            ),
            "/admin/partners",
            ['Ese partner esta perdido por que su identificador no existe, esto es raro :/']
        );

        if(!File::isEmptyFile($request['img'])){
            //significa que subio la imagen
            $this->redirectWithBoolCondition(
                !File::setFile($request['img']),
                "/admin/partners",
                ['Tu archivo es invalido']
            );
    
            $this->redirectWithBoolCondition(
                !File::upload(),
                "/admin/partners",
                ['Ocurrio un error al subir la imagen']
            );
            $urlImg = File::lastFileUploadInfo('rute:upload');
        }else{
            $urlImg = $this->partner()->getUrlImgById(
                $id
            );
        }

        $this->partner()->updatePartner(
            $id,
            $validate->input("name"),
            $validate->input("description"),
            $urlImg,
            $validate->input("latitude"),
            $validate->input("longitude")
        );
        $this->redirectWithBoolCondition(
            true,
            "/admin/partners",
            ['El partner ha sido actualizado con exito!']
        );
    }

    public function delete($request){
        $validate = validate($request);
        $validate->rule("required", ['identifier']);
        $this->validateFieldsWithRedirection("/admin/partners", $validate);

        $this->partner()->deleteById(
            $validate->input("identifier")
        );
        $this->redirectWithBoolCondition(
            true,
            "/admin/partners",
            ['El partner ha sido eliminado con exito!']
        );
    }
}