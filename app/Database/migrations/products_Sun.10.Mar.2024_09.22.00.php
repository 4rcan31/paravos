<?php

class products extends Migration {
        
    public function up() {
        $this->create("products", function($table) {
            $this->query('CREATE TABLE products (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                price DECIMAL(10, 2) NOT NULL,
                category_id INT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id)
            )');

            // Agregar 5 productos para cada categoría
            for ($i = 1; $i <= 4; $i++) { // suponiendo que las categorías tienen ids del 1 al 4
                for ($j = 1; $j <= 5; $j++) {
                    $this->prepare();
                    $this->insert('products')->values([
                        'name' => "Producto $j de la categoría $i",
                        'description' => "Descripción del producto $j",
                        'price' => rand(10, 100), // Precio aleatorio entre 10 y 100
                        'category_id' => $i,
                    ]);
                    $this->execute();
                }
            }
        });
    }
        
    public function down() {
        $this->dropIfExist("products");
    }
        
}

