<?php

class CategoriesViewController extends BaseController{


    public function categories() : CategoriesModel{
        return model("CategoriesModel");
    }

    public function show(){
        view("admin/categories", [
            'table' => $this->getTableCategories()
        ]);
    }


    public function getTableCategories(){
        return [
            'columns' => ['id', 'name', 'created_at'],
            'rows' => objectToArray($this->categories()->get())
        ];
    }
}