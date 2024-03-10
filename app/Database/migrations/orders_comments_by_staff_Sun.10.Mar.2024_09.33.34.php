<?php

class orders_comments_by_staff extends Migration {
        
    public function up() {
        $this->create("orders_comments_by_staff", function($table) {
            $this->query('CREATE TABLE orders_comments_by_staff (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_order INT,
                id_staff INT,
                priority VARCHAR(20),
                comment_status VARCHAR(20),
                attachment VARCHAR(255) DEFAULT NULL,
                private_note TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (id_order) REFERENCES orders(id),
                FOREIGN KEY (id_staff) REFERENCES staff(id)
            )');
        });
    }
        
    public function down() {
        $this->dropIfExist("orders_comments_by_staff");
    }
        
}
