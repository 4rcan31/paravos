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
        });
    }
        
    public function down() {
        $this->dropIfExist("products");
    }
        
}
