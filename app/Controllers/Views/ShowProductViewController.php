<?php


class ShowProductViewController extends BaseController{


    private function productsModel() : ProductsModel{
        return model('ProductsModel');
    }

    public function show($request){
        $idProduct = $request[0]; //esto hay que validarlo por si al caso xd
        view("show", $this->buildData(
            $this->productsModel()->getDataProductById($idProduct)
        ));
    }

    public function buildData(array $data) {
        $data = $data[0]; // Considera si realmente necesitas esta línea, depende de cómo esté estructurado tu conjunto de datos.
        $return = [];
    
        $return['image'] = $data['url_img'];
        $return['descriptions'] = [
            'short' => $data['description_short'],
            'large' => $data['description_large']
        ];
    
        $return['button'] = [
            'order' => [
                "string" => "Ordenar", // Cambiado de 'nobre botom' a 'Ordenar'
                'redirect' => 'http://google.com' //esto se cambiara a una página para ordenar,
            ]
        ];
    
        $return['category'] = $data['category_name'];
        $return['name'] = $data['product_name']; // Cambiado de 'Esto es el nombre' a $data['product_name']
        $return['price'] = $data['price'];
        $return['stock'] = $data['stock'];
        return $return;
    }
    
}