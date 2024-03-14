<?Php


class ProductsModel extends BaseModel{


    public function get(){
        return $this->query("SELECT c.name AS category_name, p.name, p.description, p.price, p.id
        FROM products p 
        INNER JOIN categories c ON p.category_id = c.id 
        ORDER BY c.name")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWithLimit($limit, $offset) {
        $query = "SELECT c.name AS category_name, p.name, p.description, p.price, p.id
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
}