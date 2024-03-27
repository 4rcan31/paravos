<?php
class partners extends Migration {
        
    public function up() {
        $this->create("partners", function($table) {
            $this->query('CREATE TABLE partners (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description VARCHAR(255) NOT NULL,
                img TEXT NOT NULL,
                latitude TEXT NOT NULL,
                longitude TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )');


            $this->prepare();
            $this->insert('partners')->values([
                'name' => "Para vos (Interno)",
                'description' => "Ecommers se productos variados",
                "img" => "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png",
                "longitude" => "92.795435",
                "latitude" => "57.633791"
            ]);
            $this->execute();

            $this->prepare();
            $this->insert('partners')->values([
                'name' => "Clinica Medica Escobar",
                'description' => "Clinica, laboratorio y farmacia para diferentes pacientes, nos hubicamos en San Martin en frente del don pollo",
                "img" => "https://upload.wikimedia.org/wikipedia/commons/3/3f/Rojos.png",
                "longitude" => "92.795435",
                "latitude" => "57.633791"
            ]);
            $this->execute();
        });
    }
        
    public function down() {
        $this->dropIfExist("partners");
    }
        
}