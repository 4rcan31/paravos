<?php

class phones extends Migration {
        
    public function up() {
        $this->create("phones", function($table) {
            $this->query('CREATE TABLE phones (
                id INT PRIMARY KEY AUTO_INCREMENT,
                number_phone VARCHAR(255) NOT NULL,
                user_id INT, -- Podría ser nulo si es un cliente registrado
                client_id INT, -- Podría ser nulo si es un cliente no registrado
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL, -- Clave foránea para usuario
                FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL -- Clave foránea para cliente
            )');
        });
    }
        
    public function down() {
        $this->dropIfExist("phones");
    }
        
}
