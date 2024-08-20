<?php

class orders_comments_by_staff extends Migration {
        
    public function up() {
        $this->create("orders_comments_logs", function($table) {
            $this->query('CREATE TABLE orders_comments_logs (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_order INT,
                id_staff INT DEFAULT NULL,
                attachment VARCHAR(255) DEFAULT NULL,
                private_note TEXT, -- Esta nota es solamente para el staff
                public_note TEXT, -- esta nota la puede ver el cliente y el staff
                type VARCHAR(100), -- Aca se puede guardar el tipo de comentario, esto sera seteado por el sistema, como comentario de cancelacion, de info, de warn etc
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
