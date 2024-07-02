<?php

class CategoriesController extends BaseController{


    public function categories() : CategoriesModel{
        return model("CategoriesModel");
    }

    public function edit($request){
       // $this->validateCsrfTokenWithRedirection($request, "/admin/categories");
        $validate = validate($request);
        $validate->rule('required', ['name', 'identifier']);
        $this->redirectWithBoolCondition(
            !$validate->validate(),
            '/admin/categories',
            $validate->err()
        );
        $this->categories()->updateNameById(
            $validate->input("name"),
            $validate->input('identifier')
        );
        $this->redirectWithBoolCondition(
            true,
            "/admin/categories",
            ["La categoria fue actualizada con exito!"]
        );
    }

    public function create($request){
        $validate = validate($request);
        $validate->rule('required', ['name']);
        $this->redirectWithBoolCondition(
            !$validate->validate(),
            '/admin/categories',
            $validate->err()
        );

        $this->categories()->new(
            $validate->input('name')
        );
        $this->redirectWithBoolCondition(
            true,
            "/admin/categories",
            ["La categoria fue creada con exito!"]
        );
    }


    //Todo: Agregar que no se pueda eliminar categoria si hay productos usandola xd
    public function delete($request){
        // $this->validateCsrfTokenWithRedirection($request, "/admin/categories");
         $validate = validate($request);
         $validate->rule('required', ['identifier']);
         $this->redirectWithBoolCondition(
             !$validate->validate(),
             '/admin/categories',
             $validate->err()
         );
         $this->categories()->deleteById(
             $validate->input('identifier')
         );
         $this->redirectWithBoolCondition(
             true,
             "/admin/categories",
             ["La categoria fue actualizada con exito!"]
         );
     }
}