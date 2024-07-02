<?php
class delivery_provaiders extends Migration {
        
    public function up() {
        $this->create("delivery_providers", function($table) {
            $this->query('CREATE TABLE delivery_providers (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            -- Esta columna es para ejecutar el evento, o el programa
                            -- que llamara a la api para setear la orden
                            -- puede ser por el momento: boxful o interno
                            -- en box full pues sera igual una llamada interna curl
                            endpoint_execute TEXT NOT NULL,
                            -- para hacerlo dinamico o lanzarlo afuera del server
                            is_same_server BOOLEAN DEFAULT TRUE,
                            -- si este servicio esta funcionando
                            is_active BOOLEAN DEFAULT TRUE,
                            email VARCHAR(255),
                            phone VARCHAR(15),
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                        )');

            $this->insert('delivery_providers')->values([
                'name' => 'Delivery Interno de paravos',
                'endpoint_execute' => "api/delivery/provaiders/interno",
                'is_same_server' => true,
                'is_active' => true,
                'email' => "da.esfra12@gmail.com",
                'phone' => "77370329"
            ]);
            $this->execute();
        });
    }
        
    public function down() {
        $this->dropIfExist("delivery_provaiders");
    }
        
}