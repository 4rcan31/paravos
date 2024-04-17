<?php

class ProductsViewController extends BaseController{

    public function products() : ProductsModel{
        return model("ProductsModel");
    }

    public function categories() : CategoriesModel{
        return model("CategoriesModel");
    }

    public function partners() : PartnersModel{
        return model("PartnersModel");
    }

    public function show(){
        view("admin/products", [
            'table' => $this->getTableProducts(),
            'categories' => $this->categories()->getJustName(),
            'partners'=> $this->partners()->getJustName()
        ]);
    }

    public function getTableProducts(){
       $colums = $this->products()->getColumns();
       $colums[] = "category_name";
       $colums[] = 'partner_name';
        return [
            'columns' => $colums,
            'rows' => $this->products()->getAll()
        ];
    }
}