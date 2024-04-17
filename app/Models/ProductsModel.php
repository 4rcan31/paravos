<?Php


class ProductsModel extends BaseModel{


    public function get(){
        return $this->query("SELECT c.name AS category_name, p.name, p.description_short, p.price, p.id, p.url_img, p.id
        FROM products p 
        INNER JOIN categories c ON p.category_id = c.id 
        ORDER BY c.name")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(){
        return $this->query("SELECT 
                                p.*,
                                c.name AS category_name,
                                pa.name AS partner_name
                            FROM products p 
                            INNER JOIN categories c ON p.category_id = c.id 
                            INNER JOIN partners pa ON p.partners_id = pa.id
                            ORDER BY c.name")->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getColumns(){
        return array_column($this->query("SHOW COLUMNS FROM products;
        ")->fetchAll(PDO::FETCH_ASSOC), "Field");
    }
    

    public function getWithLimit($limit, $offset) {
        $query = "SELECT c.name AS category_name, p.name, p.description_short, p.price, p.id, p.url_img, p.id
                  FROM products p 
                  INNER JOIN categories c ON p.category_id = c.id
                  LIMIT ?, ?";
        return $this->query($query, [$offset, $limit])->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function countP(){
        $this->prepare();
        $this->select()->count()->from("products");
        return $this->execute()->fetchColumn();
    }


    public function getDataProductById(int $id) {
        $query = 'SELECT 
            products.description_large,
            products.description_short,
            products.url_img,
            products.price,
            categories.name AS category_name,
            products.name as product_name,
            products.stock,
            partners.name AS partner_name,
            partners.description AS partner_description
        FROM 
            products
        JOIN 
            categories ON products.category_id = categories.id
        LEFT JOIN 
            partners ON products.partners_id = partners.id
        WHERE 
            products.id = ?';
        
        return $this->query($query, [$id])->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function existsProductById(string $id){
        $this->prepare();
        $this->select(['*'])->from("products")->where("id", $id);
        return $this->execute()->exists();
    }

    public function updateStock(int $id, int $newValueStock) : void{
        $this->prepare();
        $this->update("products", [
            "stock" => $newValueStock
        ])->where("id", $id);
        $this->execute();
    }
    
    public function stockById(string $id) : int{
        $this->prepare();
        $this->select(['stock'])->from("products")->where("id", $id);
        $result = $this->execute()->all();
        return $result ? $result->stock : -1;
    }

    public function getXProductsLasted(string $limit){
        return $this->query("SELECT * FROM products
        ORDER BY created_at DESC
        LIMIT ?", [$limit])->fetchAll(PDO::FETCH_ASSOC);
    }
}