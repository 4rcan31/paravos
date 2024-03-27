<?php

class HomeViewController extends BaseController{

    public function products() : ProductsModel{
        return model("ProductsModel");
    }


    public function show(){
        view("index", $this->products()->getXProductsLasted(
            $this->maxProductsShowInHome()
        ));
    }

    public function maxProductsShowInHome() : int{
        return 6;
    }
}