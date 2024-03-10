<?php

class clients extends Migration {
        
    public function up() {
        $this->create("clients", function($table) {
            $this->query('CREATE TABLE clients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                full_name VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
        });
    }
        
    public function down() {
        $this->dropIfExist("clients");
    }
        
}
