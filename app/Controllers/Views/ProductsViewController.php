<?php


class ProductsViewController extends BaseController{

    private function productsModel() : ProductsModel{
        return model('ProductsModel');
    }

    public function products($request) {
        $page = $request[0] ?? 1;
        $offset = $this->getOffet($page);
        $limit = $this->limit();
    
        view("products", [
            "products" => $this->getProductsByCategories($limit, $offset),
            "page" => $page,
            "totalpages" => $this->totalPages(),
            "maxButtonsShow" => $this->maxButtonsShow()
        ]);
    }


    public function getProductsByCategories($limit = 0, $offset = 0) {
        $products = ($limit == 0 && $offset == 0) ? 
        $this->productsModel()->get() :
        $this->productsModel()->getWithLimit($limit, $offset);
        return array_reduce($products, function ($result, $product) {
            $categoryName = $product['category_name'];
            $result[$categoryName][] = [
                "name" => $product['name'],
                "description_short" => $product['description_short'],
                "img" => $product['url_img'], // No estoy seguro de dónde se obtiene la imagen
                "price" => $product["price"],
                "showpage" =>  server()->RouteAbsolute("show/".$product['id'])
            ];
    
            return $result;
        }, []);
    }
    

    public function limit(){
        return 3;
    }

    public function maxButtonsShow(){
        return 10;
    }

    function getOffet($page){
        return ($page - 1) * $this->limit();
    }

    public function totalPages(){
        return ceil($this->productsModel()->countP() / $this->limit());
    }
}