<?php

class ProductsController extends BaseController{


    public function product() : ProductsModel{
        return model("ProductsModel");
    }

    public function category() : CategoriesModel{
        return model("CategoriesModel");
    }

    public function partner() : PartnersModel{
        return model("PartnersModel");
    }

    public function create($request){
        $validate = validate($request);
        $validate->rule("required", [
            'name',
            'price',
            'description_large',
            'description_short',
            'stock',
            'category',
            'partner',
            'img'
        ]);
        $validate->rule("numeric", [
            'price',
            'stock'
        ]);
        $this->redirectWithBoolCondition(
            !$validate->validate(),
            "/admin/products",
            $validate->err()
        );


        //validar que esa categoria exista
        $this->redirectWithBoolCondition(
            !$this->category()->existByName(
                $validate->input("category")
            ),
            "/admin/products",
            ["La categoria ".$validate->input("category")." no existe"]
        );

        //validar parner
        $this->redirectWithBoolCondition(
            !$this->partner()->existByName(
                $validate->input("partner")
            ),
            "/admin/products",
            ["El partner ".$validate->input("partner")." no existe"]
        );


        $this->redirectWithBoolCondition(
            !File::setFile($request['img']),
            "/admin/products",
            ['Tu archivo es invalido']
        );

        $this->redirectWithBoolCondition(
            !File::upload(),
            "/admin/products",
            ['Ocurrio un error al subir la imagen']
        );
        
        $this->product()->new(
            $this->category()->getIdByName(
                $validate->input("category")
            ),
            $this->partner()->getIdByName(
                $validate->input('partner')
            ),
            $validate->input("name"),
            $validate->input("description_large"),
            $validate->input("description_short"),
            $validate->input("stock"),
            $validate->input("price"),
            File::lastFileUploadInfo('rute:upload')
        );
        $this->redirectWithBoolCondition(
            true,
            "/admin/products",
            ['El producto '.$validate->input("name")." ha sido creado correctamente!"]
        );
    }

    public function edit($request){
        $validate = validate($request);
        $validate->rule("required", [
            'name',
            'price',
            'description_large',
            'description_short',
            'stock',
            'category',
            'partner',
            "identifier"
        ]);
        $validate->rule("numeric", [
            'price',
            'stock'
        ]);
        $this->validateFieldsWithRedirection("/admin/products", $validate);
        $id = $validate->input("identifier");
        $this->redirectWithBoolCondition(
            !$this->product()->existById(
                $id
            ),
            "/admin/products",
            ['Ese producto esta perdido por que su identificador no existe, esto es raro :/']
        );

        if(!File::isEmptyFile($request['img'])){
            //significa que subio la imagen
            $this->redirectWithBoolCondition(
                !File::setFile($request['img']),
                "/admin/products",
                ['Tu archivo es invalido']
            );
    
            $this->redirectWithBoolCondition(
                !File::upload(),
                "/admin/products",
                ['Ocurrio un error al subir la imagen']
            );
            $urlImg = File::lastFileUploadInfo('rute:upload');
        }else{
            $urlImg = $this->product()->getUrlImgById(
                $id
            );
        }


        $this->product()->updateP(
            $this->category()->getIdByName(
                $validate->input("category")
            ),
            $this->partner()->getIdByName(
                $validate->input('partner')
            ),
            $validate->input("name"),
            $validate->input("description_large"),
            $validate->input("description_short"),
            $validate->input("stock"),
            $validate->input("price"),
            $urlImg,
            $id
        );

        $this->redirectWithBoolCondition(
            true,
            "/admin/products",
            ['El producto ha sido actualizado con exito!']
        );
    }


    public function delete($request){
        $validate = validate($request);
        $validate->rule("required", ['identifier']);
        $this->validateFieldsWithRedirection("/admin/products", $validate);

        $this->product()->deleteById(
            $validate->input("identifier")
        );
        $this->redirectWithBoolCondition(
            true,
            "/admin/products",
            ['El producto ha sido eliminado con exito!']
        );
    }
}