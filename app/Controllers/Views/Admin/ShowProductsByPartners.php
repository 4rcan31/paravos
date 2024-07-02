<?php


class ShowProductsByPartners extends BaseController{

    public function products() : ProductsModel{
        return model("ProductsModel");
    }

    public function categories() : CategoriesModel{
        return model("CategoriesModel");
    }

    public function partners() : PartnersModel{
        return model("PartnersModel");
    }

    public function show($request){
        $id = $request[0] ?? 1;
        view("admin/showproductspartners", [
            'table' => $this->getTableProducts($id),
            'categories' => $this->categories()->getJustName(),
            'partners'=> $this->partners()->getJustName()
        ]);
    }

    public function getTableProducts($id){
       $colums = $this->products()->getColumnsPro();
       $colums[] = "category_name";
       $colums[] = 'partner_name';
        return [
            'columns' => $colums,
            'rows' => $this->products()->getAllByPartnerId($id)
        ];
    }
}