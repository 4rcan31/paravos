<?php

class Address extends Migration {
        
    public function up() {
        $this->create("addresses", function($table) {
            $this->query('CREATE TABLE addresses (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                is_principal BOOLEAN DEFAULT FALSE,
                address_line VARCHAR(255),
                address_line2 VARCHAR(255),
                city VARCHAR(255) NOT NULL, -- municipio en este caso
                state VARCHAR(255) NOT NULL, -- departamento en este caso
                country VARCHAR(255) DEFAULT "El Salvador",
                place VARCHAR(255) NOT NULL,
                postal_code VARCHAR(20) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )');
            
            
            $this->query('CREATE TRIGGER update_address_line BEFORE INSERT ON addresses
        FOR EACH ROW
        BEGIN
            SET NEW.address_line = CONCAT(NEW.city, ", ", NEW.state, ", ", NEW.country, ", ", NEW.place);
        END');

             
        });

        // Insertar la dirección principal
        $this->prepare();
        $this->insert("addresses")->values([
            "user_id" => 1,
            "is_principal" => true,
            "city" => "Example City",
            "state" => "Example State",
            "postal_code" => "12345",
            "place" => "plaza mundo"
        ]); 
        $this->execute();

        // Insertar otra dirección
        $this->prepare();
        $this->insert("addresses")->values([
            "user_id" => 1,
            "is_principal" => false,
            "city" => "Another City",
            "state" => "Another State",
            "postal_code" => "67890",
            "place" => "plaza mundo"
        ]); 
        $this->execute();
    }
        
    public function down() {
        $this->dropIfExist("addresses");
    }
        
}
