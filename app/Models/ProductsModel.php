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

    public function getAllByPartnerId(string $id){
        return $this->query("SELECT 
        p.*,
        c.name AS category_name,
        pa.name AS partner_name
    FROM products p 
    INNER JOIN categories c ON p.category_id = c.id 
    INNER JOIN partners pa ON p.partners_id = pa.id
    WHERE partners_id = ?
    ORDER BY c.name
    ", [$id])->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getColumnsPro(){
        return $this->getColumns("products");
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

    public function new(
        string $categoryId, 
        string $partnerId, 
        string $name, 
        string $descriptionLarge, 
        string $descriptionShort, 
        int|string $stock, 
        float|string $price, 
        string $urlImg
    ) {
        $this->prepare();
        $this->insert("products")->values([
            "category_id" => $categoryId,
            "partners_id" => $partnerId,
            "name" => $name,
            "description_large" => $descriptionLarge,
            "description_short" => $descriptionShort,
            "stock" => $stock,
            "price" => $price,
            "url_img" => $urlImg
        ]);
        return $this->execute()->lastId();
    }

    public function updateP(
        string $categoryId, 
        string $partnerId, 
        string $name, 
        string $descriptionLarge, 
        string $descriptionShort, 
        int|string $stock, 
        float|string $price, 
        string $urlImg,
        string $id
    ) {
        $this->prepare();
        $this->update("products", [
            "category_id" => $categoryId,
            "partners_id" => $partnerId,
            "name" => $name,
            "description_large" => $descriptionLarge,
            "description_short" => $descriptionShort,
            "stock" => $stock,
            "price" => $price,
            "url_img" => $urlImg
        ])->where("id", $id);
        return $this->execute()->lastId();
    }
    

    public function getUrlImgById(string $id) : string{
        $this->prepare();
        $this->select(['url_img'])->from("products")->where("id", $id);
        return $this->execute()->all()->url_img;
    }



    public function existById(string $id) : bool{
        $this->prepare();
        $this->select(['*'])->from("products")->where("id", $id);
        return $this->execute()->exists();
    }

    public function deleteById(string $id){
        $this->prepare();
        $this->delete("products")->where('id', $id);
        return $this->execute();
    }

}