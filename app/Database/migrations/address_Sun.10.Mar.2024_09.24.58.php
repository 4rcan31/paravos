<?php

class address extends Migration {
        
    public function up() {
        $this->create("addresses", function($table) {
            $this->query('CREATE TABLE addresses (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT, -- Podría ser nulo si es un cliente registrado
                client_id INT, -- Podría ser nulo si es un cliente no registrado
                address_line1 VARCHAR(255) NOT NULL,
                address_line2 VARCHAR(255),
                city VARCHAR(255) NOT NULL,
                state VARCHAR(255) NOT NULL,
                country VARCHAR(255) NOT NULL,
                postal_code VARCHAR(20) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL, -- Clave foránea para usuario
                FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL -- Clave foránea para cliente
            )');
        });
    }
        
    public function down() {
        $this->dropIfExist("addresses");
    }
        
}
