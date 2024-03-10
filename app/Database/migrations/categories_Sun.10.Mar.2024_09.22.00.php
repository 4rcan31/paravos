<?php

class categories extends Migration {
        
    public function up() {
        $this->create("categories", function($table) {
            $this->query('CREATE TABLE categories (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
        });
    }
        
    public function down() {
        $this->dropIfExist("categories");
    }
        
}
