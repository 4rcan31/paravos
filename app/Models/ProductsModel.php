<?Php


class ProductsModel extends BaseModel{


    public function get(){
        return $this->query("SELECT c.name AS category_name, p.name, p.description_short, p.price, p.id, p.url_img, p.id
        FROM products p 
        INNER JOIN categories c ON p.category_id = c.id 
        ORDER BY c.name")->fetchAll(PDO::FETCH_ASSOC);
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
    
    
}