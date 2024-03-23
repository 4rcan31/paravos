<?php

class products extends Migration {
        
    public function up() {
        $this->create("products", function($table) {
            $this->query('CREATE TABLE products (
                id INT PRIMARY KEY AUTO_INCREMENT,
                category_id INT,
                partners_id INT,
                name VARCHAR(255) NOT NULL,
                description_large TEXT,
                description_short TEXT,
                url_img TEXT,
                stock INT DEFAULT 1,
                price DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (category_id) REFERENCES categories(id),
                FOREIGN KEY (partners_id) REFERENCES partners(id)
            )');

            for ($i = 1; $i <= 4; $i++) { // suponiendo que las categorías tienen ids del 1 al 4
                for ($j = 1; $j <= 5; $j++) {
                    $this->prepare();
                    $this->insert('products')->values([
                        'name' => "Nombre",
                        'partners_id' => 1, //uno es el pather principal
                        'description_large' => "Descripción larga del producto $j",
                        'description_short' => "Descripción Corta del producto $j",
                        'url_img' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png',
                        'price' => rand(10, 100), // Precio aleatorio entre 10 y 100
                        'stock' => rand(10, 25),
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

