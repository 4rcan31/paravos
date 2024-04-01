<?php

class orders extends Migration {
        
    public function up() {
        $this->create("orders", function($table) {
            $this->query('CREATE TABLE orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                user_id INT DEFAULT NULL, -- Uno por que el cliente por default sera "1"
                address TEXT NOT NULL,
                reference TEXT DEFAULT NULL,
                email VARCHAR(255),
                phone VARCHAR(20) NOT NULL,
                payment_status VARCHAR(20), -- puede ser: Pendiente, Completado, Cancelado
                tracking_number VARCHAR(255),
                shipping_date DATE,
                delivery_time TIME,
                notes TEXT DEFAULT NULL,
                payment_method VARCHAR(50) DEFAULT "Efectivo", -- por el momento todo sera efectivo xd
                order_status VARCHAR(20), -- Puede ser: Entregado, Pendiente, Cancelado
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES products(id),
                FOREIGN KEY (user_id) REFERENCES users(id) -- Clave foránea para 
            )');
            /* 
                Tanto user_id como client_id pueden ser nulos.
Si el pedido es realizado por un cliente registrado, entonces el user_id se asigna, mientras que el client_id se deja nulo.
Si el pedido es realizado por un cliente no registrado, entonces el client_id se asigna, mientras que el user_id se deja nulo.
Esto permite manejar órdenes de clientes registrados y no registrados de manera flexible, sin requerir la presencia obligatoria de un usuario en el sistema para realizar un pedido.
            */
        });
    }
        
    public function down() {
        $this->dropIfExist("orders");
    }
        
}
